<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use \Illuminate\Support\Str;
use Valourite\FormBuilder\Filament\Enums\FieldType;

class FieldRepeater extends Repeater
{
    public static function make(?string $name = null): static
    {
        $component = parent::make($name);

        $component
            ->label('Form Field')
            ->grid(2)
            ->columnSpanFull()
            //->columns(1)
            // ->collapsible()
            // ->collapsed()
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
                                ColorPicker::make('colour')
                                    ->label('Colour')
                                    ->helperText('This is the colour of the field'),

                                Select::make('prefix_icon')
                                    ->label('Prefix Icon')
                                    ->options(
                                        collect(Heroicon::cases())
                                            ->mapWithKeys(fn($icon) => [
                                                $icon->value => Str::title(str_replace('-', ' ', $icon->value)),
                                            ])
                                            ->toArray()
                                    )
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(function ($value) {
                                        return Blade::render(
                                            '<div class="flex items-center gap-2">
                                                <x-dynamic-component :component="$icon" class="w-4 h-4 text-gray-500" />
                                                <span>{{ $label }}</span>
                                            </div>',
                                            [
                                                'icon' => $value,
                                                'label' => $value,
                                            ]
                                        );
                                    })
                                    ->helperText('Choose a Heroicon to prefix the field.'),

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