<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductForm
{
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            // =========================
            // PRODUCT NAME
            // =========================
            TextInput::make('en_name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) =>
                    $set('slug', str()->slug($state))
                ),

            // =========================
            // SLUG
            // =========================
            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            // =========================
            // IMAGE UPLOAD
            // =========================
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('products'),

            // =========================
            // CATEGORY
            // =========================
            Select::make('category_id')
                ->relationship('category', 'en_category_name')
                ->preload()
                ->searchable()
                ->required(),

            // =========================
            // BRAND
            // =========================
            Select::make('brand_id')
                ->relationship('brand', 'en_brand_name')
                ->preload()
                ->searchable()
                ->required(),

            // =========================
            // PRICE
            // =========================
            TextInput::make('price')
                ->numeric()
                ->required()
                ->live(onBlur: true),

            // =========================
            // DISCOUNT %
            // =========================
            TextInput::make('discount')
                ->numeric()
                ->default(0)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, $set, $get) {
                    $price = $get('price') ?? 0;
                    $set('discounted_price', $price - ($price * $state / 100));
                }),

            // =========================
            // FINAL PRICE
            // =========================
            TextInput::make('discounted_price')
                ->numeric()
                ->disabled(),

            // =========================
            // STOCK
            // =========================
            TextInput::make('quantity')
                ->numeric()
                ->default(0),

            // =========================
            // STATUS FLAGS
            // =========================
            Toggle::make('is_active')->default(true),
            Toggle::make('is_featured'),
            Toggle::make('is_best_selling'),
            Toggle::make('is_new_arrival'),
            Toggle::make('is_onsale'),
        ]);
    }
}