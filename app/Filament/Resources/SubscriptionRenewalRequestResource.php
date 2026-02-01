<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionRenewalRequestResource\Pages;
use App\Models\SubscriptionRenewalRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRenewalRequestResource extends Resource
{
    protected static ?string $model = SubscriptionRenewalRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'طلبات التجديد';

    protected static ?string $modelLabel = 'طلب تجديد';

    protected static ?string $pluralModelLabel = 'طلبات التجديد';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'إدارة الاشتراكات';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الطلب')
                    ->schema([

                        Forms\Components\TextInput::make('transfer_number')
                            ->label('رقم الحوالة')
                            ->disabled(),

                        Forms\Components\Textarea::make('notes')
                            ->label('ملاحظات')
                            ->disabled()
                            ->rows(3),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('transfer_image')
                            ->label('صورة الحوالة')
                            ->collection('transfer_image')
                            ->disabled()
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('حالة الطلب')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'pending' => 'قيد الانتظار',
                                'approved' => 'تم التجديد',
                                'rejected' => 'مرفوض',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\DateTimePicker::make('reviewed_at')
                            ->label('تاريخ المراجعة')
                            ->disabled(),


                    ])
                    ->columns(3)
                    ->visible(fn ($record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\TextColumn::make('admin.name')
                    ->label('المدير')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('transfer_number')
                    ->label('رقم الحوالة')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-hashtag'),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('transfer_image')
                    ->label('صورة الحوالة')
                    ->collection('transfer_image')
                    ->circular(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('الملاحظات')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->notes),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'approved' => 'تم التجديد',
                        'rejected' => 'مرفوض',
                    })
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('تاريخ المراجعة')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort(fn (Builder $query) =>
                $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                      ->orderBy('created_at', 'desc')
            )
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'approved' => 'تم التجديد',
                        'rejected' => 'مرفوض',
                    ])
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('قبول')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->isPending())
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                            'reviewed_at' => now(),
                            'reviewed_by' => optional(auth())->id(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('تم قبول الطلب')
                            ->body('تم تجديد اشتراك المدير بنجاح')
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->isPending())
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'rejected',
                            'reviewed_at' => now(),
                            'reviewed_by' => optional(auth())->id(),
                        ]);

                        Notification::make()
                            ->warning()
                            ->title('تم رفض الطلب')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
   public static function canViewAny(): bool
    {
        return auth()->user()?->can('view Subscription') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create Subscription') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update Subscription') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete Subscription') ?? false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionRenewalRequests::route('/'),
            'create' => Pages\CreateSubscriptionRenewalRequest::route('/create'),
            'view' => Pages\ViewSubscriptionRenewalRequest::route('/{record}'),
            'edit' => Pages\EditSubscriptionRenewalRequest::route('/{record}/edit'),
        ];
    }
}
