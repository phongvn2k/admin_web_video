<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentProcessResource\Pages;
use App\Filament\Resources\PaymentProcessResource\RelationManagers;
use App\Models\PaymentProcess;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentProcessResource extends Resource
{
    protected static ?string $model = PaymentProcess::class;

    protected static ?string $navigationGroup = 'Cài đặt';

    protected static ?string $modelLabel = 'Tiến trình rút tiền';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Tiến trình')
                    ->required()
                    ->maxLength(255),

                TextInput::make('order')
                    ->label('Thứ tự')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tiến trình')
                    ->sortable(),

                TextColumn::make('order')
                    ->label('Thứ tự')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPaymentProcesses::route('/'),
            'create' => Pages\CreatePaymentProcess::route('/create'),
            'edit' => Pages\EditPaymentProcess::route('/{record}/edit'),
        ];
    }
}
