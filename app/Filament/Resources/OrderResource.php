<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Resident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'الطلبات';
    protected static ?string $modelLabel = 'طلب';
    protected static ?string $pluralModelLabel = 'الطلبات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('OrderTabs')
                ->persistTabInQueryString()
                ->tabs([
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
                                            if (! $state) return;

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

                // ✅ Resident
                Tables\Columns\TextColumn::make('resident.name')
                    ->label('المقيم')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->limit(22)
                    ->tooltip(fn ($record) => $record->resident?->name),

                // ✅ Branch
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('الفرع')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-m-building-office-2')
                    ->color('success'),


                Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->label('الصور')
                    ->collection('images')
                    ->circular()
                    ->stacked()
                    ->limit(3),

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
                // ✅ Branch filter
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('الفرع')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),

                // ✅ Status filter
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending'  => 'قيد الانتظار',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض',
                        'done'     => 'مكتمل',
                    ]),
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
])

            ->emptyStateHeading('لا توجد طلبات')
            ->emptyStateDescription('جرّب تغيير الفلاتر أو إضافة طلب جديد.')
            ->emptyStateIcon('heroicon-m-inbox')
            ->defaultSort('submitted_at', 'desc');
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
