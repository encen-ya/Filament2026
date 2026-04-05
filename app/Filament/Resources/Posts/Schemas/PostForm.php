<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Details')
                ->description('Fill in the details of the post')
                ->icon('heroicon-o-document-text')
                ->schema([

                    Group::make([
                        TextInput::make('title')
                        ->rules('required | min:5 | max:10')
                        ->validationMessages([
                            'required' => 'Title is required',
                            'min' => 'Title minimal 5 karakter',
                            'max' => 'Title maksimal 10 karakter',
                        ]),
                        TextInput::make('slug')
                        ->rules('required | min:3 | max:10')
                        ->unique()
                        ->validationMessages([
                            'unique' => 'Slug must be unique',
                        ]),
                        Select::make('category_id')
                        ->relationship('category', 'name')
                        ->preload()
                        ->required()
                        ->searchable(),
                        ColorPicker::make('color'),
                    ])->columns(2),

                    MarkdownEditor::make('content')
                        ->columnSpanFull(),

                    ]),

                Group::make([
                Section::make('Image Upload')
                ->icon('heroicon-o-photo')
                ->schema([
                FileUpload::make('image')
                ->required()
                ->disk('public')
                ->directory('posts'),
                ]),

                Section::make('Meta Information')
                ->icon('heroicon-o-information-circle')
                ->schema([
                TagsInput::make('tags'),
                Checkbox::make('is_published'),
                ])->columns(2),
                ]),
                
                DateTimePicker::make('published_at'),
                ])->columns(2);
    } 
} 
