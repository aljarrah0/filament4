<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\User;
use App\Models\Product;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->required()
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('product_id')
                    ->required()
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
            ]);
    }
}
