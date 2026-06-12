<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Ordered Products';

    public function table(Table $table): Table
    {
        return $table

            // =========================
            // COLUMNS
            // =========================
            ->columns([

                // PRODUCT NAME
                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable(),

                // QUANTITY
                TextColumn::make('quantity')
                    ->badge()
                    ->color('warning'),

                // PRICE
                TextColumn::make('price')
                    ->money('USD'),

                // SUBTOTAL
                TextColumn::make('subtotal')
                    ->getStateUsing(fn ($record) =>
                        $record->price * $record->quantity
                    )
                    ->money('USD')
                    ->label('Subtotal'),
            ])

            // =========================
            // DISABLE CREATE/DELETE
            // =========================
            ->headerActions([])

            ->recordActions([])

            ->toolbarActions([]);
    }
}