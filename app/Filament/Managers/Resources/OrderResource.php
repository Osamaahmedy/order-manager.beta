<?php

namespace App\Filament\Managers\Resources;

use App\Filament\Managers\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Services\OrderExportService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Admin;
use App\Models\Resident;
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'الطلبات';

    protected static ?string $modelLabel = 'طلب';

    protected static ?string $pluralModelLabel = 'الطلبات';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $admin = auth()->user();
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();
        return $query->whereIn('branch_id', $branchIds);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الطلب')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('رقم المرجعية')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('number')
                            ->label('رقم الطلب')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Select::make('resident_id')
                            ->label('المقيم')
                            ->relationship('resident', 'name')
                            ->disabled()
                            ->dehydrated(true),

                        Forms\Components\Select::make('branch_id')
                            ->label('الفرع')
                            ->relationship('branch', 'name')
                            ->disabled()
                            ->dehydrated(true),

                        Forms\Components\DateTimePicker::make('submitted_at')
                            ->label('تاريخ الإرسال')
                            ->disabled()
                            ->dehydrated(true)
                            ->displayFormat('Y-m-d H:i'),
  Forms\Components\Section::make('معلومات المنشئ')
                    ->schema([
                        Forms\Components\Placeholder::make('created_by_info')
                            ->label('')
                            ->content(function ($record) {
                                if (!$record || !$record->created_by_type) {
                                    return '—';
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
                    ])
                    ->collapsed(false)
                    ->visible(fn($record) => $record && $record->created_by_type),


                        Forms\Components\Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->disabled()
                            ->dehydrated(true)
                            ->columnSpanFull(),
                             // إضافة تطبيق التوصيل
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

                    ])
                    ->columns(2),

                Forms\Components\Section::make('الصور')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('images')
                            ->label('صور الطلب')
                            ->multiple()
                            ->disabled()
                            ->downloadable()
                            ->openable()
                            ->imagePreviewHeight('200')
                            ->helperText('يمكنك عرض وتحميل الصور فقط - لا يمكن التعديل'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('رقم المرجعيه')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('primary'),

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

                // ✅ عمود: صنف المنشئ
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





                Tables\Columns\TextColumn::make('branch.name')
                    ->label('الفرع')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('info')
                    ->weight('bold'),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->label('الصور')
                    ->collection('images')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                        Tables\Columns\TextColumn::make('deliveryApp.name')
                    ->label('تطبيق التوصيل')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-truck')
                    ->badge()
                    ->color('warning')
                    ->placeholder(''),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),

                // ✅ اكسبورت طلب واحد Word
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
            ->bulkActions([
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
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
