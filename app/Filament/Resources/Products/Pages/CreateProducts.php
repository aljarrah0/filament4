<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Products\ProductsResource;

class CreateProducts extends CreateRecord
{
    protected static string $resource = ProductsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Multiply the price by 100 before saving to the database
        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 100;
        }
        return $data;
    }
}
