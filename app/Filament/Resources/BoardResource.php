<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardResource\Pages;
use App\Models\Board;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class BoardResource extends Resource
{
    protected static ?string $model = Board::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-tablet';

    protected static ?string $navigationLabel = 'Mesas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')->required()->label('Nome'),
                        TextInput::make('guest_number')->label('Lugares')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(8),
                        Toggle::make('available')
                            ->onIcon('heroicon-s-lightning-bolt')
                            ->offIcon('heroicon-s-user')
                            ->required()->label('Disponível'),

                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->label('Nome'),
                TextColumn::make('guest_number')->sortable()->searchable()->label('Lugares'),
                BooleanColumn::make('available')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable()
                    ->label('Disponível'),
            ])
            ->filters([
                Filter::make('Disponível')
                    ->query(fn (Builder $query): Builder => $query->where('available', true)),
                Filter::make('Não Disponível')
                    ->query(fn (Builder $query): Builder => $query->where('available', false)),
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
            'index' => Pages\ListBoards::route('/'),
            'create' => Pages\CreateBoard::route('/create'),
            'edit' => Pages\EditBoard::route('/{record}/edit'),
        ];
    }
}
