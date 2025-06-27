<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Valourite\FormBuilder\Models\Form;

class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make(Form::FROM_NAME)
                    ->label('Form Name')
                    ->helperText('The unique name of the form')
                    ->reactive()
                    ->debounce(5000)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if ($state) {
                            $set(Form::FORM_SLUG, str($state)->slug());
                        }
                    })
                    ->required(),

                TextInput::make(Form::FORM_SLUG)
                    ->label('Form Slug')
                    ->disabled()
                    ->dehydrated() //alows the field to be saved
                    ->required()
                    ->helperText('The slug of the form'),
                
                Textarea::make(Form::FORM_DESCRIPTION)
                    ->label('Form Description'),

                Textarea::make(Form::FORM_CONFIRMATION_MESSAGE)
                    ->label('Form Confirmation Message'),

                Toggle::make(Form::IS_ACTIVE)
                    ->default(true)
                    ->label('Is Form Active?')
                    ->required(),
                
                Select::make(Form::FORM_MODEL)
                    ->label('Form Model')
                    ->options(
                        collect(config('form-builder.models', []))
                            ->mapWithKeys(fn ($class) => [$class => class_basename($class)])
                            ->toArray()
                    )
                    ->required(),

                //Form content will be set when the form repeater is used
                TextInput::make(Form::FORM_CONTENT)
                    ->default('{}')
                    ->hidden()
                    ->dehydrated(), //allows the field to be saved

                TextInput::make(Form::FORM_VERSION)
                    ->default('0.0.1')
                    ->maxLength(10)
                    ->required(),
            ]);
    }
}
