<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Products\ProductsResource;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
