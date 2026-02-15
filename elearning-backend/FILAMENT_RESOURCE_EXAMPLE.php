<?php

/**
 * EXAMPLE: How to create your own Filament Resource
 * 
 * This is a template showing how to add more resources to your admin panel.
 * You can use this as a reference when creating resources for other models.
 *
 * Common steps:
 * 1. Create a Model (if you don't have one)
 * 2. Create a Filament Resource using the template below
 * 3. Create corresponding Pages (List, Create, Edit)
 * 4. Add to your Filament provider
 */

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Replace 'YourModel' with your actual model name
// Example: use App\Models\Product;

class ExampleResource extends Resource
{
    // Replace with your model class
    protected static ?string $model = null; // Set to: YourModel::class

    // Icon from Heroicons (https://heroicons.com)
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Label shown in navigation and header
    protected static ?string $navigationLabel = 'Example Items';

    // Model title attribute (used for display)
    protected static ?string $recordTitleAttribute = 'name';

    // Sort order in navigation menu
    protected static ?int $navigationSort = 0;

    /**
     * Define the form fields for Create/Edit pages
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Example Text Input
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Item Name'),

                // Example Email Input
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(),

                // Example Textarea
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpan('full'),

                // Example Select
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                // Example Toggle
                Forms\Components\Toggle::make('is_active')
                    ->default(true),

                // Example Date Picker
                Forms\Components\DatePicker::make('publish_date'),

                // Example Number Input
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->step(0.01),
            ]);
    }

    /**
     * Define the table columns and actions
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Register the routes for this resource
     */
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ExampleResource\Pages\ListExamples::route('/'),
            'create' => \App\Filament\Resources\ExampleResource\Pages\CreateExample::route('/create'),
            'edit' => \App\Filament\Resources\ExampleResource\Pages\EditExample::route('/{record}/edit'),
        ];
    }
}

/**
 * CREATE LIST PAGE
 * File: app/Filament/Resources/ExampleResource/Pages/ListExamples.php
 */
/*
namespace App\Filament\Resources\ExampleResource\Pages;

use App\Filament\Resources\ExampleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExamples extends ListRecords
{
    protected static string $resource = ExampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
*/

/**
 * CREATE CREATE PAGE
 * File: app/Filament/Resources/ExampleResource/Pages/CreateExample.php
 */
/*
namespace App\Filament\Resources\ExampleResource\Pages;

use App\Filament\Resources\ExampleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExample extends CreateRecord
{
    protected static string $resource = ExampleResource::class;
}
*/

/**
 * CREATE EDIT PAGE
 * File: app/Filament/Resources/ExampleResource/Pages/EditExample.php
 */
/*
namespace App\Filament\Resources\ExampleResource\Pages;

use App\Filament\Resources\ExampleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExample extends EditRecord
{
    protected static string $resource = ExampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
*/
