<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'الفروع';

    protected static ?string $modelLabel = 'فرع';

    protected static ?string $pluralModelLabel = 'الفروع';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'إدارة مشتركين النظام';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم القسم')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('location')
                            ->label('الموقع')
                            ->maxLength(255),

                        // Forms\Components\Select::make('admins')
                        //     ->label('المسؤولين')
                        //     ->relationship('admins', 'name')
                        //     ->multiple()
                        //     ->preload()
                        //     ->searchable()
                        //     ->helperText('المسؤولين المرتبطين بهذا القسم'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم القسم')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('الموقع')
                    ->searchable(),

                Tables\Columns\TextColumn::make('admins_count')
                    ->label('عدد المسؤولين')
                    ->counts('admins')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
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
        return auth()->user()?->can('view Branch') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create Branch') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update Branch') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete Branch') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
