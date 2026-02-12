<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Resident;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Services\OrderExportService;

use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'الطلبات';
    protected static ?string $modelLabel = 'طلب';
    protected static ?string $pluralModelLabel = 'الطلبات';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'إدارة مشتركين النظام';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('OrderTabs')
                ->persistTabInQueryString()
                ->tabs([
                    // ✅ Tab 1: معلومات الطلب
                    Forms\Components\Tabs\Tab::make('معلومات الطلب')
                        ->icon('heroicon-m-document-text')
                        ->schema([
                            Forms\Components\Section::make('البيانات الأساسية')
                                ->description('تفاصيل الطلب والمقيم والفرع')
                                ->icon('heroicon-m-clipboard-document-check')
                                ->compact()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('order_number')
                                        ->label('رقم المرجعية')
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->placeholder('سيتم إنشاؤه تلقائياً')
                                        ->hint('Auto')
                                        ->hintIcon('heroicon-m-sparkles'),

                                    Forms\Components\TextInput::make('number')
                                        ->label('رقم الطلب')
                                        ->disabled()
                                        ->placeholder('—'),

                                    Forms\Components\Select::make('resident_id')
                                        ->label('المقيم')
                                        ->relationship('resident', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->reactive()
                                        ->hint('ابحث بالاسم')
                                        ->hintIcon('heroicon-m-magnifying-glass')
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if (!$state) return;

                                            $resident = Resident::find($state);
                                            if ($resident) {
                                                $set('branch_id', $resident->branch_id);
                                            }
                                        }),

                                    Forms\Components\Select::make('branch_id')
                                        ->label('الفرع')
                                        ->relationship('branch', 'name')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->helperText('يتم ملؤه تلقائياً من بيانات المقيم')
                                        ->hint('Auto')
                                        ->hintIcon('heroicon-m-sparkles'),

                                    Forms\Components\Select::make('delivery_app_id')
                                        ->label('تطبيق التوصيل')
                                        ->relationship('deliveryApp', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->nullable()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('اسم التطبيق')
                                                ->required()
                                                ->maxLength(255),
                                        ])
                                        ->hint('اختياري')
                                        ->hintIcon('heroicon-m-truck'),

                                    Forms\Components\DateTimePicker::make('submitted_at')
                                        ->label('تاريخ الإرسال')
                                        ->default(now())
                                        ->required()
                                        ->displayFormat('Y-m-d H:i')
                                        ->seconds(false)
                                        ->hint('يظهر في الفرز')
                                        ->hintIcon('heroicon-m-clock'),

                                    Forms\Components\Textarea::make('notes')
                                        ->label('ملاحظات')
                                        ->rows(4)
                                        ->columnSpanFull()
                                        ->placeholder('اكتب أي تفاصيل إضافية...')
                                        ->hint('اختياري')
                                        ->hintIcon('heroicon-m-pencil-square'),
                                ]),
                        ]),

                    // ✅ Tab 2: معلومات المنشئ
                    Forms\Components\Tabs\Tab::make('معلومات المنشئ')
                        ->icon('heroicon-m-user')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Placeholder::make('created_by_info')
                                        ->label('')
                                        ->content(function ($record) {
                                            if (!$record || !$record->created_by_type) {
                                                return new \Illuminate\Support\HtmlString(
                                                    '<div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg text-center">
                                                        <span class="text-gray-500 dark:text-gray-400">لا توجد معلومات عن المنشئ</span>
                                                    </div>'
                                                );
                                            }

                                            $isAdmin = $record->created_by_type === Admin::class;
                                            $creator = null;

                                            if ($isAdmin) {
                                                $creator = Admin::find($record->created_by_id);
                                                $type = '👤 مسؤول';
                                                $icon = '🔑';
                                            } else {
                                                $creator = Resident::find($record->created_by_id);
                                                $type = '👥 مقيم';
                                                $icon = '📱';
                                            }

                                            if (!$creator) {
                                                return 'غير معروف';
                                            }

                                            return new \Illuminate\Support\HtmlString(
                                                '<div class="space-y-2 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-2xl">' . $icon . '</span>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">تم الإنشاء بواسطة</div>
                                                            <div class="text-lg font-bold text-gray-900 dark:text-white">' . e($creator->name) . '</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                                        <span class="inline-flex items-center gap-1">
                                                            <span>الصنف:</span>
                                                            <span class="font-semibold">' . $type . '</span>
                                                        </span>
                                                        ' . ($isAdmin
                                                            ? '<span>📧 ' . e($creator->email ?? '') . '</span>'
                                                            : '<span>📞 ' . e($creator->phone ?? '') . '</span>'
                                                        ) . '
                                                    </div>
                                                </div>'
                                            );
                                        })
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->visible(fn($record) => $record && $record->created_by_type),

                    // ✅ Tab 3: الصور
                    Forms\Components\Tabs\Tab::make('الصور')
                        ->icon('heroicon-m-photo')
                        ->schema([
                            Forms\Components\Section::make('صور الطلب')
                                ->description('يمكن رفع صور متعددة مع ترتيبها')
                                ->icon('heroicon-m-camera')
                                ->compact()
                                ->schema([
                                    SpatieMediaLibraryFileUpload::make('images')
                                        ->collection('images')
                                        ->label('صور الطلب')
                                        ->multiple()
                                        ->reorderable()
                                        ->maxFiles(10)
                                        ->image()
                                        ->downloadable()
                                        ->openable()
                                        ->imageEditor()
                                        ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1'])
                                        ->panelLayout('grid')
                                        ->helperText('يمكنك رفع حتى 10 صور')
                                        ->hint('JPG/PNG')
                                        ->hintIcon('heroicon-m-information-circle'),
                                ]),
                        ]),

                    // ✅ Tab 4: الفيديو
                    Forms\Components\Tabs\Tab::make('الفيديو')
                        ->icon('heroicon-m-video-camera')
                        ->schema([
                            Forms\Components\Section::make('فيديو الطلب')
                                ->description('يمكن رفع ملف فيديو واحد (حد أقصى 100 ميجابايت)')
                                ->icon('heroicon-m-film')
                                ->compact()
                                ->schema([
                                    SpatieMediaLibraryFileUpload::make('videos')
                                        ->collection('videos')
                                        ->label('فيديو الطلب')
                                        ->acceptedFileTypes(['video/mp4', 'video/mpeg', 'video/quicktime', 'video/x-msvideo', 'video/webm'])
                                        ->maxSize(102400) // 100 ميجابايت
                                        ->downloadable()
                                        ->openable()
                                        ->helperText('صيغ مدعومة: MP4, MOV, AVI, WEBM')
                                        ->hint('حد أقصى 100MB')
                                        ->hintIcon('heroicon-m-information-circle'),
                                ]),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ✅ Ref
                Tables\Columns\TextColumn::make('order_number')
                    ->label('المرجعية')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->icon('heroicon-m-hashtag')
                    ->color('primary')
                    ->weight(FontWeight::Bold),

                // ✅ Number
                Tables\Columns\TextColumn::make('number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->icon('heroicon-m-ticket')
                    ->color('info')
                    ->weight(FontWeight::Bold),

                // ✅ المنشئ
                Tables\Columns\TextColumn::make('created_by_type')
                    ->label('المنشئ')
                    ->formatStateUsing(function ($record) {
                        if (!$record->created_by_type) {
                            return '—';
                        }

                        $isAdmin = $record->created_by_type === Admin::class;

                        if ($isAdmin) {
                            $creator = Admin::find($record->created_by_id);
                            return $creator ? '👤 ' . $creator->name : '—';
                        } else {
                            $creator = Resident::find($record->created_by_id);
                            return $creator ? '👥 ' . $creator->name : '—';
                        }
                    })
                    ->badge()
                    ->color(fn($record) =>
                        $record->created_by_type === Admin::class ? 'warning' : 'info'
                    )
                    ->searchable(false)
                    ->sortable(false)
                    ->toggleable(),

                // ✅ صنف المنشئ
                Tables\Columns\IconColumn::make('is_admin_created')
                    ->label('صنف')
                    ->getStateUsing(fn($record) => $record->created_by_type === Admin::class)
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('warning')
                    ->falseColor('info')
                    ->tooltip(fn($record) =>
                        $record->created_by_type === Admin::class ? 'مسؤول' : 'مقيم'
                    )
                    ->alignCenter()
                    ->toggleable(),

                // ✅ المقيم
                Tables\Columns\TextColumn::make('resident.name')
                    ->label('المقيم')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-m-user')
                    ->color('gray')
                    ->placeholder('—'),

                // ✅ Branch
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('الفرع')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-m-building-office-2')
                    ->color('success'),

                // ✅ Delivery App
                Tables\Columns\TextColumn::make('deliveryApp.name')
                    ->label('تطبيق التوصيل')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-truck')
                    ->badge()
                    ->color('warning')
                    ->placeholder('—'),

                // ✅ Images
                Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->label('الصور')
                    ->collection('images')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->ring(2)
                    ->overlap(4),

                // ✅ Video indicator
                Tables\Columns\IconColumn::make('has_video')
                    ->label('فيديو')
                    ->getStateUsing(fn($record) => $record->getMedia('videos')->count() > 0)
                    ->boolean()
                    ->trueIcon('heroicon-o-video-camera')
                    ->falseIcon('heroicon-o-video-camera-slash')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('الإرسال')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // ✅ فلتر صنف المنشئ
                Tables\Filters\SelectFilter::make('created_by_type')
                    ->label('صنف المنشئ')
                    ->options([
                        Admin::class => '👤 مسؤول',
                        Resident::class => '👥 مقيم',
                    ])
                    ->placeholder('الكل'),

                // ✅ Branch filter
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('الفرع')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),

                // ✅ Delivery App filter
                Tables\Filters\SelectFilter::make('delivery_app_id')
                    ->label('تطبيق التوصيل')
                    ->relationship('deliveryApp', 'name')
                    ->searchable()
                    ->preload(),

                // ✅ Has Video filter
                Tables\Filters\TernaryFilter::make('has_video')
                    ->label('يحتوي على فيديو')
                    ->queries(
                        true: fn($query) => $query->whereHas('media', fn($q) => $q->where('collection_name', 'videos')),
                        false: fn($query) => $query->whereDoesntHave('media', fn($q) => $q->where('collection_name', 'videos')),
                    ),
                    Tables\Filters\Filter::make('created_at')
    ->label('تاريخ الإنشاء')
    ->form([
        Forms\Components\DatePicker::make('from')
            ->label('من تاريخ'),
        Forms\Components\DatePicker::make('until')
            ->label('إلى تاريخ'),
    ])
    ->query(function (Builder $query, array $data): Builder {
        return $query
            ->when(
                $data['from'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
            )
            ->when(
                $data['until'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
            );
    }),
            ])
            ->bulkActions([
    Tables\Actions\DeleteBulkAction::make(),

                // ✅ اكسبورت جماعي Word
                BulkAction::make('export_word_bulk')
                    ->label('📄 تصدير Word')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function (Collection $records) {
                        $service = new OrderExportService();
                        $filePath = $service->exportToWord($records, 'orders_bulk');
                        return $service->download($filePath, 'الطلبات_' . now()->format('Y-m-d') . '.docx');
                    })
                    ->requiresConfirmation()
                    ->modalHeading('تصدير إلى Word')
                    ->modalDescription('هل تريد تصدير الطلبات المحددة إلى ملف Word؟')
                    ->modalSubmitActionLabel('تصدير')
                    ->modalCancelActionLabel('إلغاء'),


                // ✅ اكسبورت جماعي Excel
                BulkAction::make('export_excel_bulk')
                    ->label('📊 تصدير Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (Collection $records) {
                        $service = new OrderExportService();
                        $filePath = $service->exportToExcel($records, 'orders_bulk');
                        return $service->download($filePath, 'الطلبات_' . now()->format('Y-m-d') . '.xlsx');
                    })
                    ->requiresConfirmation()
                    ->modalHeading('تصدير إلى Excel')
                    ->modalDescription('هل تريد تصدير الطلبات المحددة إلى ملف Excel؟')
                    ->modalSubmitActionLabel('تصدير')
                    ->modalCancelActionLabel('إلغاء'),


                // ✅ اكسبورت الكل جماعي
                BulkAction::make('export_all_bulk')
                    ->label('📦 تصدير الكل')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('warning')
                    ->action(function () {
                        $admin = auth()->user();
                        $branchIds = $admin->branches()->pluck('branches.id')->toArray();
                        $records = Order::whereIn('branch_id', $branchIds)->get();

                        $service = new OrderExportService();
                        $filePath = $service->exportToWord($records, 'all_orders');
                        return $service->download($filePath, 'جميع_الطلبات_' . now()->format('Y-m-d') . '.docx');
                    })
                    ->requiresConfirmation()
                    ->modalHeading('تصدير جميع الطلبات')
                    ->modalDescription('هل تريد تصدير جميع الطلبات إلى ملف Word؟')
                    ->modalSubmitActionLabel('تصدير')
                    ->modalCancelActionLabel('إلغاء'),
])

            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('عرض')
                    ->icon('heroicon-m-eye')
                    ->color('gray')
                    ->extraAttributes([
                        'class' =>
                            'transition-all duration-200 ' .
                            'hover:-translate-y-0.5 hover:shadow-md ' .
                            'focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-400',
                    ]),

                Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->extraAttributes([
                        'class' =>
                            'transition-all duration-200 ' .
                            'hover:-translate-y-0.5 hover:shadow-md ' .
                            'focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-400',
                    ]),

                Action::make('export_word')
                    ->label('📄 Word')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function (Order $record) {
                        $service = new OrderExportService();
                        $filePath = $service->exportToWord(
                            collect([$record]),
                            'order_' . $record->order_number
                        );
                        return $service->download($filePath, 'طلب_' . $record->order_number . '.docx');
                    })
                    ->tooltip('تصدير هذا الطلب إلى ملف Word'),
Action::make('export_pdf')
    ->label('📄 PDF')
    ->color('danger')
    ->action(function (Order $record) {
        $service = new OrderExportService();
        $filePath = $service->exportToPdf(
            collect([$record]),
            'order_' . $record->order_number
        );
        return $service->download(
            $filePath,
            'طلب_' . $record->order_number . '.pdf'
        );
    }),

                // ✅ اكسبورت طلب واحد Excel
                Action::make('export_excel')
                    ->label('📊 Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (Order $record) {
                        $service = new OrderExportService();
                        $filePath = $service->exportToExcel(
                            collect([$record]),
                            'order_' . $record->order_number
                        );
                        return $service->download($filePath, 'طلب_' . $record->order_number . '.xlsx');
                    })
                    ->tooltip('تصدير هذا الطلب إلى ملف Excel'),
            ])
            ->emptyStateHeading('لا توجد طلبات')
            ->emptyStateDescription('جرّب تغيير الفلاتر أو إضافة طلب جديد.')
            ->emptyStateIcon('heroicon-m-inbox')
            ->defaultSort('submitted_at', 'desc');
    }
     public static function canViewAny(): bool
    {
        return auth()->user()?->can('view orders') ?? false;
    }



    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update orders') ?? false;
    }



    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
            'view'   => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
