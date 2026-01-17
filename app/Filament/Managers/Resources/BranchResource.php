<?php

namespace App\Filament\Managers\Resources;

use App\Filament\Managers\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'الفروع';

    protected static ?string $modelLabel = 'فرع';

    protected static ?string $pluralModelLabel = 'الفروع';

    protected static ?int $navigationSort = 1;

    // ✅ عرض فروع الـ Admin الحالي فقط
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('admins', function ($query) {
                $query->where('admins.id', auth()->id());
            });
    }

    public static function form(Form $form): Form
    {
        $admin = auth()->user();
        $subscription = $admin->subscription();

        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الفرع')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الفرع')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('مثال: فرع صنعاء الرئيسي'),

                        Forms\Components\Textarea::make('location')
                            ->label('الموقع')
                            ->required()
                            ->rows(3)
                            ->placeholder('العنوان الكامل'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->helperText('إذا كان معطلاً، لن يتمكن المقيمون من العمل'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('معلومات الاشتراك')
                    ->schema([
                        Forms\Components\Placeholder::make('subscription_info')
                            ->label('حالة الاشتراك')
                            ->content(function () use ($admin, $subscription) {
                                if (!$subscription) {
                                    return '⚠️ لا يوجد اشتراك نشط';
                                }

                                $used = $admin->branches()->count();
                                $limit = $subscription->plan->max_branches ?? '∞';
                                $remaining = $subscription->getRemainingQuota('branches');

                                return "الفروع المستخدمة: {$used} / {$limit}\nالمتبقي: {$remaining}";
                            }),
                    ])
                    ->visible(fn ($context) => $context === 'create')
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الفرع')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-building-office'),

                Tables\Columns\TextColumn::make('location')
                    ->label('الموقع')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('resident.name')
                    ->label('المقيم')
                    ->default('لا يوجد')
                    ->badge()
                    ->color(fn ($state) => $state === 'لا يوجد' ? 'gray' : 'success'),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label('الطلبات')
                    ->counts('orders')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('النشطة فقط')
                    ->falseLabel('المعطلة فقط'),

                Tables\Filters\Filter::make('has_resident')
                    ->label('لديه مقيم')
                    ->query(fn (Builder $query) => $query->has('resident')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('toggle_status')
                    ->label(fn ($record) => $record->is_active ? 'تعطيل' : 'تفعيل')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_active ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['is_active' => !$record->is_active]);

                        Notification::make()
                            ->title('تم تحديث الحالة')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->resident) {
                            Notification::make()
                                ->title('لا يمكن الحذف')
                                ->body('يجب حذف المقيم أولاً')
                                ->danger()
                                ->send();

                            return false;
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('لا توجد فروع')
            ->emptyStateDescription('ابدأ بإضافة أول فرع')
            ->emptyStateIcon('heroicon-o-building-office')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة فرع')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getEloquentQuery()->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function canCreate(): bool
    {
        $admin = auth()->user();
        return $admin->canAddBranch();
    }
}
