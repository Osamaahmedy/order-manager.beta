<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'خطط الاشتراك';

    protected static ?string $modelLabel = 'خطة';

    protected static ?string $pluralModelLabel = 'الخطط';

    protected static ?string $navigationGroup = 'إدارة الاشتراكات';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الخطة')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الخطة')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('مثال: الباقة الأساسية'),

                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('وصف مختصر للخطة ومميزاتها')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('price')
                            ->label('السعر')
                            ->numeric()
                            ->prefix('ر.ي')
                            ->required()
                            ->minValue(0)
                            ->step(0.01),

                        Forms\Components\Select::make('interval')
                            ->label('فترة الاشتراك')
                            ->options([
                                'monthly' => 'شهري',
                                'yearly' => 'سنوي',
                                'lifetime' => 'مدى الحياة',
                            ])
                            ->required()
                            ->default('monthly'),

                        Forms\Components\TextInput::make('trial_days')
                            ->label('أيام التجربة المجانية')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->suffix('يوم')
                            ->helperText('صفر = بدون فترة تجريبية'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->helperText('إذا كانت معطلة، لن تظهر للمستخدمين'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('الحدود والقيود')
                    ->description('اترك الحقل فارغاً لعدد غير محدود')
                    ->schema([
                        Forms\Components\TextInput::make('max_branches')
                            ->label('الحد الأقصى للفروع')
                            ->numeric()
                            ->minValue(1)
                            ->suffix('فرع')
                            ->placeholder('∞ غير محدود'),

                        Forms\Components\TextInput::make('max_residents')
                            ->label('الحد الأقصى للمقيمين')
                            ->numeric()
                            ->minValue(1)
                            ->suffix('مقيم')
                            ->placeholder('∞ غير محدود'),

                        Forms\Components\TextInput::make('max_orders_per_month')
                            ->label('الحد الأقصى للطلبات شهرياً')
                            ->numeric()
                            ->minValue(1)
                            ->suffix('طلب/شهر')
                            ->placeholder('∞ غير محدود'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('المميزات الإضافية')
                    ->schema([
                        Forms\Components\TagsInput::make('features')
                            ->label('قائمة المميزات')
                            ->placeholder('اكتب ميزة واضغط Enter')
                            ->helperText('مثل: تقارير متقدمة، دعم فني 24/7، API Access')
                            ->suggestions([
                                'تقارير متقدمة',
                                'دعم فني 24/7',
                                'API Access',
                                'نسخ احتياطي يومي',
                                'تصدير البيانات',
                                'تكامل مع الأنظمة الخارجية',
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الخطة')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-bookmark'),

                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('YER')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\BadgeColumn::make('interval')
                    ->label('الفترة')
                    ->colors([
                        'success' => 'monthly',
                        'warning' => 'yearly',
                        'primary' => 'lifetime',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'monthly' => 'شهري',
                        'yearly' => 'سنوي',
                        'lifetime' => 'مدى الحياة',
                        default => $state,
                    })
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('max_branches')
                    ->label('الفروع')
                    ->default('∞')
                    ->alignCenter()
                    ->color('info'),

                Tables\Columns\TextColumn::make('max_residents')
                    ->label('المقيمين')
                    ->default('∞')
                    ->alignCenter()
                    ->color('info'),

                Tables\Columns\TextColumn::make('max_orders_per_month')
                    ->label('الطلبات/شهر')
                    ->default('∞')
                    ->alignCenter()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('trial_days')
                    ->label('التجربة المجانية')
                    ->formatStateUsing(fn ($state) => $state > 0 ? "{$state} يوم" : 'لا يوجد')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('المشتركين')
                    ->counts('subscriptions')
                    ->badge()
                    ->color('success')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('price', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('النشطة فقط')
                    ->falseLabel('المعطلة فقط'),

                Tables\Filters\SelectFilter::make('interval')
                    ->label('فترة الاشتراك')
                    ->options([
                        'monthly' => 'شهري',
                        'yearly' => 'سنوي',
                        'lifetime' => 'مدى الحياة',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('toggle_status')
                        ->label(fn ($record) => $record->is_active ? 'تعطيل' : 'تفعيل')
                        ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn ($record) => $record->is_active ? 'warning' : 'success')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['is_active' => !$record->is_active])),

                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation()
                        ->modalDescription('سيتم حذف الخطة نهائياً. لن يؤثر على الاشتراكات الموجودة.'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('لا توجد خطط اشتراك')
            ->emptyStateDescription('ابدأ بإنشاء أول خطة اشتراك')
            ->emptyStateIcon('heroicon-o-currency-dollar')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('إنشاء خطة جديدة')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
