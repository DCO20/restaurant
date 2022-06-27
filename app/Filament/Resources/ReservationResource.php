<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Rules\TimeBetween;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static ?string $navigationLabel = 'Reservas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('first_name')->label('Primeiro Nome')->required(),
                        TextInput::make('last_name')->label('Sobrenome')->required(),
                        TextInput::make('email')->label('Email')->required()->email(),
                        TextInput::make('tel_number')->label('Telefone')
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(00)00000-0000'))
                            ->required(),
                        DateTimePicker::make('res_date')->label('Horario da Reserva')
                            ->withoutSeconds()
                            ->minDate(now())
                            ->rules([new TimeBetween()])
                            ->required(),
                        Select::make('board_id')
                            ->label('Mesa')
                            ->relationship('board', 'name', function ($query) {
                                return $query->where('available', true);
                            })
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->guest_number}) Lugares"),
                        Toggle::make('completed')
                            ->onIcon('heroicon-s-lightning-bolt')
                            ->offIcon('heroicon-s-user')
                            ->required()->label('Completa'),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->sortable()->searchable()->label('Primeiro Nome'),
                TextColumn::make('last_name')->sortable()->searchable()->label('Sobrenome'),
                TextColumn::make('email')->sortable()->searchable()->label('Email'),
                TextColumn::make('tel_number')->sortable()->searchable()->label('Telefone'),
                TextColumn::make('res_date')->dateTime()->label('Horario da Reserva'),
                TextColumn::make('board.name')->sortable()->searchable()->label('Mesa'),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
