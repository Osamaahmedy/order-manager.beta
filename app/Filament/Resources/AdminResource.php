<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'المسؤولين';

    protected static ?string $modelLabel = 'مسؤول';

    protected static ?string $pluralModelLabel = 'المسؤولين';
     protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'إدارة مشتركين النظام';



    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['subscriptions' => function ($query) {
                $query->where('status', 'active')->latest();
            }, 'branches']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('05xxxxxxxx')
                            ->validationMessages([
                                'unique' => 'رقم الهاتف مستخدم مسبقاً',
                                'required' => 'رقم الهاتف مطلوب',
                            ]),

                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->revealable()
                            ->minLength(8)
                            ->maxLength(255)
                            ->helperText('اتركها فارغة للاحتفاظ بكلمة المرور الحالية'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('معلومات الاشتراك')
                    ->schema([
                        Forms\Components\Placeholder::make('current_plan')
                            ->label('الخطة الحالية')
                            ->content(function (?Model $record) {
                                if (!$record) {
                                    return '-';
                                }
                                $sub = $record->subscription();
                                if (!$sub) {
                                    return 'لا يوجد اشتراك';
                                }

                                $planName = $sub->plan->name;
                                $interval = $sub->plan->getIntervalInArabic();
                                $price = $sub->plan->price . ' ر.ي';

                                return "{$planName} ({$interval}) - {$price}";
                            }),

                        Forms\Components\Placeholder::make('subscription_status')
                            ->label('حالة الاشتراك')
                            ->content(function (?Model $record) {
                                if (!$record) {
                                    return '-';
                                }
                                $sub = $record->subscription();
                                if (!$sub) {
                                    return 'لا يوجد اشتراك';
                                }

                                return match($sub->status) {
                                    'active' => 'نشط',
                                    'canceled' => 'ملغي',
                                    'expired' => 'منتهي',
                                    'suspended' => 'معلق',
                                    default => $sub->status,
                                };
                            }),

                        // ✅ تاريخ البداية
                        Forms\Components\Placeholder::make('subscription_start')
                            ->label('تاريخ البداية')
                            ->content(function (?Model $record) {
                                if (!$record) {
                                    return '-';
                                }
                                $sub = $record->subscription();
                                if (!$sub) {
                                    return 'لا يوجد';
                                }

                                return $sub->starts_at->format('Y-m-d');
                            }),

                        // ✅ تاريخ الانتهاء
                        Forms\Components\Placeholder::make('subscription_end')
                            ->label('تاريخ الانتهاء')
                            ->content(function (?Model $record) {
                                if (!$record) {
                                    return '-';
                                }
                                $sub = $record->subscription();
                                if (!$sub) {
                                    return 'لا يوجد';
                                }

                                // ✅ إذا لم يكن هناك تاريخ انتهاء
                                if (!$sub->ends_at) {
                                    return 'لا يوجد';
                                }

                                return $sub->ends_at->format('Y-m-d');
                            }),

                        Forms\Components\Placeholder::make('branches_usage')
                            ->label('استخدام الفروع')
                            ->content(function (?Model $record) {
                                if (!$record) {
                                    return '-';
                                }
                                $sub = $record->subscription();
                                if (!$sub) {
                                    $used = $record->branches()->count();
                                    return "{$used} / غير محدود";
                                }

                                $used = $record->branches()->count();
                                $limit = $sub->plan->max_branches ?? 'غير محدود';
                                $remaining = $sub->getRemainingQuota('branches');

                                return "{$used} / {$limit} (متبقي: {$remaining})";
                            }),

                        Forms\Components\Placeholder::make('residents_usage')
                            ->label('استخدام المقيمين')
                            ->content(function (?Model $record) {
                                if (!$record) {
                                    return '-';
                                }
                                $sub = $record->subscription();
                                if (!$sub) {
                                    $used = $record->residents()->count();
                                    return "{$used} / غير محدود";
                                }

                                $used = $record->residents()->count();
                                $limit = $sub->plan->max_residents ?? 'غير محدود';
                                $remaining = $sub->getRemainingQuota('residents');

                                return "{$used} / {$limit} (متبقي: {$remaining})";
                            }),
                    ])
                    ->columns(3)
                    ->visible(fn ($context) => $context === 'edit'),

                Forms\Components\Section::make('الفروع')
                    ->schema([
                        Forms\Components\Select::make('branches')
                            ->label('الأقسام')
                            ->relationship('branches', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText(function (?Model $record) {
                                if (!$record) {
                                    return 'يمكن اختيار أكثر من قسم';
                                }

                                $sub = $record->subscription();
                                if (!$sub) {
                                    return 'لا يوجد اشتراك - يمكنك الاختيار بحرية';
                                }

                                $remaining = $sub->getRemainingQuota('branches');
                                return "المتبقي: {$remaining}";
                            })
                            ->dehydrated(true),
                    ])
                    ->visible(fn ($context) => $context === 'edit'),
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

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->icon('heroicon-m-envelope')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('subscription_plan')
                    ->label('الخطة')
                    ->badge()
                    ->getStateUsing(function (Admin $record) {
                        $sub = $record->subscription();
                        if (!$sub) return null;

                        return $sub->plan->name;
                    })
                    ->color(function ($state) {
                        return $state ? 'success' : 'danger';
                    })
                    ->default('لا يوجد')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('name', $direction);
                    }),

                Tables\Columns\BadgeColumn::make('subscription_status')
                    ->label('حالة الاشتراك')
                    ->getStateUsing(function (Admin $record) {
                        $sub = $record->subscription();
                        return $sub ? $sub->status : null;
                    })
                    ->colors([
                        'success' => 'active',
                        'warning' => 'suspended',
                        'danger' => function ($state) {
                            return in_array($state, ['canceled', 'expired']);
                        },
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'active' => 'نشط',
                            'canceled' => 'ملغي',
                            'expired' => 'منتهي',
                            'suspended' => 'معلق',
                            default => '-',
                        };
                    })
                    ->default('-'),

                // ✅ عمود تاريخ البداية
                Tables\Columns\TextColumn::make('subscription_starts')
                    ->label('تاريخ البداية')
                    ->getStateUsing(function (Admin $record) {
                        $sub = $record->subscription();
                        if (!$sub) return null;

                        return $sub->starts_at->format('Y-m-d');
                    })
                    ->default('لا يوجد')
                    ->toggleable(),

                // ✅ عمود تاريخ الانتهاء (بدون الأيام المتبقية)
                Tables\Columns\TextColumn::make('subscription_ends')
                    ->label('تاريخ الانتهاء')
                    ->getStateUsing(function (Admin $record) {
                        $sub = $record->subscription();

                        // ✅ إذا لم يكن هناك اشتراك
                        if (!$sub) return null;

                        // ✅ إذا لم يكن هناك تاريخ انتهاء
                        if (!$sub->ends_at) return null;

                        return $sub->ends_at->format('Y-m-d');
                    })
                    ->color(function (Admin $record) {
                        $sub = $record->subscription();
                        if (!$sub || !$sub->ends_at) return 'gray';

                        $days = $sub->daysRemaining();

                        if ($days <= 0) return 'danger';
                        if ($days <= 7) return 'warning';
                        return 'success';
                    })
                    ->default('لا يوجد')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('branches_count')
                    ->label('الفروع')
                    ->counts('branches')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('has_subscription')
                    ->label('حالة الاشتراك')
                    ->options([
                        'active' => 'نشط',
                        'expired' => 'منتهي',
                        'none' => 'بدون اشتراك',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'active') {
                            return $query->whereHas('subscriptions', function ($q) {
                                $q->where('status', 'active');
                            });
                        }
                        if ($data['value'] === 'expired') {
                            return $query->whereHas('subscriptions', function ($q) {
                                $q->whereIn('status', ['expired', 'canceled']);
                            });
                        }
                        if ($data['value'] === 'none') {
                            return $query->doesntHave('subscriptions');
                        }
                        return $query;
                    }),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('manage_subscription')
                        ->label('إدارة الاشتراك')
                        ->icon('heroicon-o-credit-card')
                        ->color('primary')
                        ->form([
                            Forms\Components\Select::make('plan_id')
                                ->label('اختر الخطة')
                                ->options(function () {
                                    return Plan::where('is_active', true)
                                        ->get()
                                        ->mapWithKeys(function ($plan) {
                                            $interval = $plan->getIntervalInArabic();
                                            return [$plan->id => "{$plan->name} - {$plan->price} ر.ي ({$interval})"];
                                        });
                                })
                                ->required()
                                ->searchable()
                                ->preload(),
                        ])
                        ->action(function (Admin $record, array $data) {
                            $plan = Plan::find($data['plan_id']);
                            $record->subscribe($plan, false);

                            Notification::make()
                                ->title('تم تفعيل الاشتراك بنجاح')
                                ->body('تم اشتراك ' . $record->name . ' في خطة ' . $plan->name)
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('view_subscription')
                        ->label('عرض تفاصيل الاشتراك')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->visible(function (Admin $record) {
                            return $record->subscription() !== null;
                        })
                        ->modalHeading('تفاصيل الاشتراك')
                        ->modalContent(function (Admin $record) {
                            $sub = $record->subscription();
                            if (!$sub) return null;

                            return view('filament.components.subscription-details', [
                                'subscription' => $sub,
                                'admin' => $record,
                            ]);
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('إغلاق'),

                    Tables\Actions\Action::make('suspend')
                        ->label('تعليق الاشتراك')
                        ->icon('heroicon-o-pause')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('تعليق الاشتراك')
                        ->modalDescription('سيتم تعطيل جميع الفروع والمقيمين التابعين')
                        ->visible(function (Admin $record) {
                            $sub = $record->subscription();
                            return $sub && $sub->status === 'active';
                        })
                        ->action(function (Admin $record) {
                            $record->subscription()->suspend('تعليق يدوي من الإدارة');

                            Notification::make()
                                ->title('تم تعليق الاشتراك')
                                ->body('تم تعطيل الفروع والمقيمين التابعين')
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\Action::make('resume')
                        ->label('استئناف الاشتراك')
                        ->icon('heroicon-o-play')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('استئناف الاشتراك')
                        ->modalDescription('سيتم تفعيل الفروع والمقيمين مرة أخرى')
                        ->visible(function (Admin $record) {
                            $sub = $record->subscription();
                            return $sub && $sub->status === 'suspended';
                        })
                        ->action(function (Admin $record) {
                            $record->subscription()->resume();

                            Notification::make()
                                ->title('تم استئناف الاشتراك')
                                ->body('تم تفعيل الموارد بنجاح')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('cancel')
                        ->label('إلغاء الاشتراك')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('إلغاء الاشتراك')
                        ->modalDescription('سيتم إلغاء الاشتراك وتعطيل جميع الموارد')
                        ->visible(function (Admin $record) {
                            $sub = $record->subscription();
                            return $sub && in_array($sub->status, ['active', 'suspended']);
                        })
                        ->action(function (Admin $record) {
                            $record->cancelSubscription();

                            Notification::make()
                                ->title('تم إلغاء الاشتراك')
                                ->danger()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('لا يوجد مسؤولين')
            ->emptyStateDescription('ابدأ بإضافة أول مسؤول')
            ->emptyStateIcon('heroicon-o-user-group')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة مسؤول')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view admin') ?? true;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create admin') ?? true;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update admin') ?? true;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete admin') ?? true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::whereHas('subscriptions', function ($q) {
            $q->where('status', 'active');
        })->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
