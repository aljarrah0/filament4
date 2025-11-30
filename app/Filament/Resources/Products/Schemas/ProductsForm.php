<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use App\Enum\ProductStatusEnum;
use App\Filament\Tables\TagsTable;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Filament\Tables\CategoriesTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ModalTableSelect;

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
                ModalTableSelect::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->tableConfiguration(CategoriesTable::class)
                    ->nullable(),
                ModalTableSelect::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->tableConfiguration(TagsTable::class)
                    ->multiple()
                    ->nullable(),
                Textarea::make('description')
                    ->label('Description')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
