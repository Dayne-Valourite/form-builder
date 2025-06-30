<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Closure;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

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
                                ColorPicker::make('colour')
                                    ->label('Colour')
                                    ->helperText('This is the colour of the section'),

                                Select::make('icon')
                                    ->label('Icon')
                                    ->options(Heroicon::class)
                                    ->helperText('This is the icon of the section'),

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