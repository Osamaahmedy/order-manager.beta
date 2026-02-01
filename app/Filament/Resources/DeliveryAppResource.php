<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryAppResource\Pages;
use App\Models\DeliveryApp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;


class DeliveryAppResource extends Resource
{
    protected static ?string $model = DeliveryApp::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'تطبيقات التوصيل';

    protected static ?string $modelLabel = 'تطبيق توصيل';

    protected static ?string $pluralModelLabel = 'تطبيقات التوصيل';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'إدارة مشتركين النظام';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم التطبيق')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('الرقم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم التطبيق')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('عدد الطلبات')
                    ->counts('orders')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
     public static function canViewAny(): bool
    {
        return auth()->user()?->can('view Delivery Apps') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create Delivery Apps') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update Delivery Apps') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete Delivery Apps') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryApps::route('/'),
            'create' => Pages\CreateDeliveryApp::route('/create'),
            'edit' => Pages\EditDeliveryApp::route('/{record}/edit'),
        ];
    }
}
