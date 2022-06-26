<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-menu';

    protected static ?string $navigationLabel = 'Menus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')->collection('categories')->label('Imagem'),
                        TextInput::make('name')->required()->label('Nome'),
                        TextInput::make('price')
                            ->mask(fn (TextInput\Mask $mask) => $mask->money('$', ',', 2))
                            ->required()
                            ->label('Preço'),
                        MultiSelect::make('category_id')
                            ->relationship('categories', 'name')
                            ->required()
                            ->label('Categorias'),
                    ])
                    ->columns(4),
                Card::make()
                    ->schema([
                        MarkdownEditor::make('description')->required()->label('Descrição'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('imagem')->collection('categories')->label('Imagem'),
                TextColumn::make('name')->sortable()->searchable()->label('Nome'),
                TextColumn::make('price')->sortable()->searchable()->label('Preço'),
                TextColumn::make('categories.name')->sortable()->searchable()->label('Categoria'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
