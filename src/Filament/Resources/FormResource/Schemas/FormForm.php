<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Valourite\FormBuilder\Filament\Components\Builder\SectionRepeater;
use Valourite\FormBuilder\Models\Form;

final class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Form Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make(Form::FROM_NAME)
                            ->label('Form Name')
                            ->helperText('The unique name of the form')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, $context) {
                                if ($context === 'edit') {
                                    return;
                                }
                                $set(Form::FORM_SLUG, Str::slug($state));
                            })
                            ->required(),

                        TextInput::make(Form::FORM_SLUG)
                            ->label('Form Slug')
                            ->maxLength(255)
                            ->reactive()
                            ->rules(['alpha_dash'])
                            //->dehydrated() // alows the field to be saved
                            ->required()
                            ->helperText('The slug of the form'),

                        RichEditor::make(Form::FORM_DESCRIPTION)
                            ->label('Form Description')
                            ->helperText('Enter the optional description of the form')
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['undo', 'redo'],
                            ]),

                        Textarea::make(Form::FORM_CONFIRMATION_MESSAGE)
                            ->label('Form Confirmation Message')
                            ->helperText('Enter the optional confirmation message of the form')
                            ->default('Your form has been submitted successfully!'),

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

                        TextInput::make(Form::FORM_VERSION)
                            ->default('0.0.1')
                            ->mask('9.9.9')
                            ->prefix('v')
                            ->maxLength(10)
                            ->required(),
                    ]),

                // Section for form creation
                Section::make('Form Creation')
                    ->schema([
                        // Create section repeater
                        SectionRepeater::make(Form::FORM_CONTENT),
                    ])
                    ->columns(1),
            ])
            ->columns(1);
    }
}
