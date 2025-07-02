<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Str;
use Valourite\FormBuilder\Filament\Enums\FieldType;

final class FieldRepeater extends Repeater
{
    public static function make(?string $name = null): static
    {
        $component = parent::make($name);

        $component
            ->label('Form Field')
            ->grid(2)
            ->columnSpanFull()
            ->schema([
                Tabs::make()
                    ->label('Field')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Field')
                            ->label('Field')
                            ->schema([
                                TextInput::make('name')
                                    ->label('name')
                                    ->required(),

                                TextInput::make('label')
                                    ->label('Label')
                                    ->helperText('This is the label of the field'),

                                Select::make('type')
                                    ->label('Type')
                                    ->options(FieldType::class)
                                    ->getOptionLabelsUsing(fn (string $label): string => Str::ucfirst($label))
                                    ->required(),
                            ]),

                        Tab::make('Options')
                            ->label('Options')
                            ->schema([
                                Checkbox::make('required')
                                    ->label('Required')
                                    ->helperText('Is this field required.'),

                                FieldHelper::select(),

                                TextInput::make('custom_id')
                                    ->label('Custom ID')
                                    ->default(uniqid('field-'))
                                    ->helperText('This is the unique custom ID of the field'),
                            ]),
                    ]),
            ])
            ->columns(2);

        return $component;
    }
}
