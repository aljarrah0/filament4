<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Products\ProductsResource;

class EditProducts extends EditRecord
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['price'])) {
            $data['price'] = $data['price'] / 100;
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Multiply the price by 100 before saving to the database
        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 100;
        }
        return $data;
    }
}
