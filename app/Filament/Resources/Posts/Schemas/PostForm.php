<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')
                    ->description('The main content of the post.')
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('slug')
                            ->required(),
                        RichEditor::make('content')
                        ->columnSpanFull(),
                    ])->columnSpan(2),
                Section::make('Meta')
                    ->description('Meta information about the post.')
                    ->collapsible()
                    ->schema([
                        Group::make()->schema([
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
                            Toggle::make('is_published')
                                ->required(),
                        ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
