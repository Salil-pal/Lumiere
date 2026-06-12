<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // =========================
            // COLUMNS
            // =========================
            ->columns([

                // PRODUCT IMAGE
                ImageColumn::make('image') ->getStateUsing(fn ($record) => asset('storage/' . $record->image)),

                // PRODUCT NAME
                TextColumn::make('en_name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                // CATEGORY
                TextColumn::make('category.en_category_name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                // BRAND
                TextColumn::make('brand.en_brand_name')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),

                // PRICE
                TextColumn::make('price')
                    ->money('BDT')
                    ->sortable(),

                // DISCOUNT %
                TextColumn::make('discount')
                    ->label('Discount %'),

                // FINAL PRICE
                TextColumn::make('discounted_price')
                    ->money('BDT'),

                // STOCK
                TextColumn::make('quantity')
                    ->label('Stock')
                    ->badge()
                    ->color(fn ($state) => match (true) {

                        $state <= 0 => 'danger',

                        $state <= 5 => 'warning',

                        default => 'success',
                    }),
                TextColumn::make('stock_status')
                    ->getStateUsing(function ($record) {

                        if ($record->stock <= 0) {
                            return 'Out of Stock';
                        }

                        if ($record->stock <= 5) {
                            return 'Low Stock';
                        }

                        return 'In Stock';
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Out of Stock' => 'danger',
                        'Low Stock' => 'warning',
                        default => 'success',
                    }),

                // STATUS
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                IconColumn::make('is_best_selling')
                    ->label('Best Selling')
                    ->boolean(),

                IconColumn::make('is_new_arrival')
                    ->label('New Arrival')
                    ->boolean(),
            ])

            // =========================
            // Filter
            // =========================

            ->filters([

                TernaryFilter::make('is_active'),

                TernaryFilter::make('is_featured'),

                TernaryFilter::make('is_best_selling'),

                TernaryFilter::make('is_new_arrival'),

                TernaryFilter::make('is_onsale'),

                Filter::make('low_stock')
                    ->query(fn ($query) =>
                        $query->where('stock', '<=', 5)
                    ),
                
                Filter::make('out_of_stock')
                    ->query(fn ($query) =>
                        $query->where('quantity', '<=', 0)
                    ),

            ])
            

            // =========================
            // ROW ACTIONS (EDIT / DELETE)
            // =========================
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            // =========================
            // BULK ACTIONS
            // =========================
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}