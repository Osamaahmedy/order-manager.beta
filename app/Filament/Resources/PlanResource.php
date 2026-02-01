<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

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
                            ])
                            ->required()
                            ->default('monthly'),


                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->helperText('إذا كانت معطلة، لن تظهر للمستخدمين'),
                    ])
                    ->columns(2),



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
                        'primary' => 'yearly',
                   ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'monthly' => 'شهري',
                        'yearly' => 'سنوي',
                        default => $state,
                    })
                    ->alignCenter(),





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
public static function canViewAny(): bool
    {
        return auth()->user()?->can('view plans') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create plans') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update plans') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete plans') ?? false;
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
