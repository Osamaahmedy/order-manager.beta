<?php

namespace App\Filament\Resources; // غير من Managers إلى Resources

use App\Filament\Resources\ResidentResource\Pages; // غير المسار
use App\Models\Resident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ResidentResource extends Resource
{
    protected static ?string $model = Resident::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'المقيمين';

    protected static ?string $modelLabel = 'مقيم';

    protected static ?string $pluralModelLabel = 'المقيمين';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'إدارة مشتركين النظام';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
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

                        Forms\Components\Select::make('branch_id')
                            ->label('القسم')
                            ->relationship('branch', 'name')
                            ->required()
                            ->searchable()
                            ->preload()

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('branch.name')
                    ->label('القسم')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('branch.location')
                    ->label('الموقع')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
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
        return auth()->user()?->can('view Resident') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create Resident') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update Resident') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete Resident') ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResidents::route('/'),
            'create' => Pages\CreateResident::route('/create'),
            'edit' => Pages\EditResident::route('/{record}/edit'),
        ];
    }
}
