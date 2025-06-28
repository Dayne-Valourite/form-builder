<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Valourite\FormBuilder\Filament\Enums\FieldType;

class FieldRepeater
{
    public static function make(): Repeater
    {
        return Repeater::make('fields')
            ->label('Form Fields')
            ->schema([
               TextInput::make('name')->required(),

               Select::make('type')
                ->options(FieldType::class)
                ->getOptionLabelsUsing(fn ($option) => ucfirst($option))
                ->required(),
                
                Textarea::make('options')
                    ->label('Options (for selects')
                    ->helperText('Comma seperated values')
                    ->visible(fn ($get) => $get('type') === FieldType::SELECT->value),
            ])
            ->columns(2);
    }
}