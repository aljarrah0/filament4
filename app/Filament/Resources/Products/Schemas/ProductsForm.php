<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use App\Enum\ProductStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ProductsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Product Name')
                    ->required(),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->rule('numeric')
                    ->prefix('EGP '),
                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options(ProductStatusEnum::class),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->nullable(),
                Textarea::make('description')
                    ->label('Description')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
