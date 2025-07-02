<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class SectionRepeater extends Repeater
{
    public static function make(?string $name = null): static
    {
        $component = parent::make($name);

        $component
            ->label('Section')
            ->collapsible()
            ->collapsed()
            ->schema([
                Tabs::make()
                    ->label('Section')
                    ->tabs([
                        Tab::make('Section')
                            ->label('Section')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required(),

                                FieldRepeater::make('Fields'),
                            ]),

                        Tab::make('Options')
                            ->label('Options')
                            ->schema([
                                FieldHelper::select(),

                                TextInput::make('custom_id')
                                    ->label('Custom ID')
                                    ->default(uniqid('sec-'))
                                    ->helperText('This is the unique custom ID of the section'),
                            ]),
                    ]),
            ]);

        return $component;
    }
}
