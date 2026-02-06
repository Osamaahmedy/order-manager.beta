<?php

namespace App\Filament\Managers\Resources;

use App\Filament\Managers\Resources\ResidentResource\Pages;
use App\Models\Resident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class ResidentResource extends Resource
{
    protected static ?string $model = Resident::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'المقيمين';

    protected static ?string $modelLabel = 'مقيم';

    protected static ?string $pluralModelLabel = 'المقيمين';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $admin = auth('admins')->user();

            if (!$admin) {
            return $query->whereRaw('1 = 0'); // لا يرجع أي نتائج
        }

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        // إرجاع المقيمين التابعين لهذه الفروع فقط
        return $query->whereIn('branch_id', $branchIds);
    }

    public static function form(Form $form): Form
    {
        $admin = auth('admins')->user();

        // ✅ التحقق من وجود Admin
        if (!$admin) {
            return $form->schema([]);
        }

        $subscription = $admin->subscription();
        $branchIds = $admin->branches()->pluck('branches.id');

        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('05xxxxxxxx')
                            ->validationMessages([
                                'unique' => 'رقم الهاتف مستخدم مسبقاً',
                            ]),

                        Forms\Components\Select::make('branch_id')
                            ->label('الفرع')
                            ->relationship(
                                'branch',
                                'name',
                                fn (Builder $query) => $query->whereIn('id', $branchIds)
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('اختر الفرع التابع له المقيم'),

                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->revealable()
                            ->minLength(6)
                            ->maxLength(255)
                            ->helperText('اتركها فارغة للاحتفاظ بكلمة المرور الحالية'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->helperText('إذا كان معطلاً، لن يتمكن من تسجيل الدخول'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('معلومات الاشتراك')
                    ->schema([
                        Forms\Components\Placeholder::make('subscription_info')
                            ->label('حالة الاشتراك')
                            ->content(function () use ($admin, $subscription) {
                                if (!$subscription) {
                                    return '⚠️ لا يوجد اشتراك نشط';
                                }

                                $used = $admin->residents()->count();
                                $limit = $subscription->plan->max_residents ?? '∞';
                                $remaining = $subscription->getRemainingQuota('residents');

                                return "المقيمين المستخدمين: {$used} / {$limit}\nالمتبقي: {$remaining}";
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
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-user'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('branch.name')
                    ->label('الفرع')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label('الطلبات')
                    ->counts('orders')
                    ->badge()
                    ->color('success'),

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
                    ->trueLabel('النشطين فقط')
                    ->falseLabel('المعطلين فقط'),

                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('الفرع')
                    ->relationship(
                        'branch',
                        'name',
                        function (Builder $query) {
                            $admin = auth()->user();
                            // ✅ التحقق من وجود Admin
                            if (!$admin) {
                                return $query->whereRaw('1 = 0');
                            }
                            return $query->whereIn(
                                'id',
                                $admin->branches()->pluck('branches.id')->toArray()
                            );
                        }
                    )
                    ->searchable()
                    ->preload(),
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

                Tables\Actions\Action::make('reset_password')
                    ->label('إعادة تعيين كلمة المرور')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->form([
                        Forms\Components\TextInput::make('new_password')
                            ->label('كلمة المرور الجديدة')
                            ->password()
                            ->required()
                            ->minLength(6)
                            ->revealable(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['password' => Hash::make($data['new_password'])]);

                        Notification::make()
                            ->title('تم تحديث كلمة المرور')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('تم الحذف')
                            ->body('تم حذف المقيم بنجاح'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('تم الحذف')
                                ->body('تم حذف المقيمين المحددين بنجاح'),
                        ),
                ]),
            ])
            ->emptyStateHeading('لا يوجد مقيمين')
            ->emptyStateDescription('ابدأ بإضافة أول مقيم لفروعك')
            ->emptyStateIcon('heroicon-o-user')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة مقيم')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResidents::route('/'),
            'create' => Pages\CreateResident::route('/create'),
            'edit' => Pages\EditResident::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // ✅ التحقق من وجود المستخدم
        $admin = auth()->user();
        if (!$admin) {
            return null;
        }

        $count = static::getEloquentQuery()->where('is_active', true)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function canCreate(): bool
    {
        $admin = auth('admins')->user();
        if (!$admin) {
            return false;
        }
        return $admin->canAddResident();
    }
}
