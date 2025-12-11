<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
enum ProductStatusEnum: string implements HasColor
{
    case IN_STOCK = 'In Stock';
    case SOLD_OUT = 'Sold Out';
    case COMING_SOON = 'Coming Soon';
    case DISCONTINUED = 'Discontinued';

    public function getColor(): string
    {
        return match ($this) {
            self::IN_STOCK => 'success',
            self::SOLD_OUT => 'danger',
            self::COMING_SOON => 'warning',
            self::DISCONTINUED => 'secondary',
        };
    }

}
