<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->default(null),
                TagsInput::make('tags')
                    ->default(null)
                    ->suggestions([
                        'tailwindcss',
                        'alpinejs',
                        'laravel',
                        'livewire',
                    ])
                    ->splitKeys(['Tab', ' '])
                    ->color('danger'),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
