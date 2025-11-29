<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ProductsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Product Name')->required(),
                TextInput::make('price')->label('Price')->required()->rule('numeric')->prefix('EGP '),
                Textarea::make('description')->label('Description')->nullable()->columnSpanFull(),
            ]);
    }
}
