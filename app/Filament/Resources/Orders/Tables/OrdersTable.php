<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Filters\SelectFilter;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table

            // =========================
            // COLUMNS
            // =========================
            ->columns([

                // ORDER NUMBER
                TextColumn::make('order_number')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                // CUSTOMER NAME
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable(),

                // EMAIL
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                // TOTAL
                TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),

                // PAYMENT METHOD
                TextColumn::make('payment_method')
                    ->badge()
                    ->color(fn ($state) => match ($state) {

                        'stripe' => 'success',
                        'paypal' => 'info',
                        'cod' => 'warning',

                        default => 'gray',
                    }),

                // ORDER STATUS
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {

                        'pending' => 'warning',

                        'paid' => 'success',

                        'processing' => 'info',

                        'shipped' => 'primary',

                        'delivered' => 'success',

                        'cancelled' => 'danger',

                        default => 'gray',
                    }),

                // USER EXISTS?
                IconColumn::make('user_id')
                    ->label('Registered User')
                    ->boolean(),

                // CREATED DATE
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])

            // =========================
            // FILTERS
            // =========================
            ->filters([

                // STATUS FILTER
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                    ]),

                // PAYMENT FILTER
                SelectFilter::make('payment_method')
                    ->options([
                        'stripe' => 'Stripe',
                        'paypal' => 'PayPal',
                        'cod' => 'Cash on Delivery',
                    ]),
            ])

            // =========================
            // ACTIONS
            // =========================
            ->recordActions([

                ViewAction::make(),

                EditAction::make(),
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