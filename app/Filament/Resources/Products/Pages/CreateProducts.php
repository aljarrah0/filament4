<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Products\ProductsResource;

class CreateProducts extends CreateRecord
{
    protected static string $resource = ProductsResource::class;
}
