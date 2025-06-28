<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class SectionRepeater extends Repeater
{
    public static function make(?string $name = null): static
    {
        $component = parent::make($name);

        $component->schema([
            TextInput::make('title')
                    ->required(),

            FieldRepeater::make(),
        ])
        ->label('Form Sections')
        ->itemLabel(fn ($state) => $state['title'] ?? 'Section')
        ->collapsible()
        ->collapsed();

        return $component;
    }
}