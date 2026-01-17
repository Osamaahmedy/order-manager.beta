<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Tables;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'الادوار';
    protected static ?string $pluralLabel = 'الادوار';
    protected static ?string $modelLabel = 'الادوار';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Role Name'),

            MultiSelect::make('permissions')
                ->relationship('permissions', 'name')
                ->label('Permissions')
                ->preload() // Preload all permissions for easier selection
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    ->badge()
                    ->separator(', '),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view roles') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create roles') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update roles') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete roles') ?? false;
    }
}
