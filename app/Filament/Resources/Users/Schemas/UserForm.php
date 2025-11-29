<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Name')->required(),
                TextInput::make('email')->label('Email')->email()->unique()->required(),
                TextInput::make('password')->label('Password')->password()->required(),
                TextInput::make('age')->label('Age')->required()->rule('numeric'),
            ]);
    }
}
