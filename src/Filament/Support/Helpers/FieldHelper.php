<?php

namespace Valourite\FormBuilder\Filament\Support\Helpers;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

/**
 * This class will be used to inject any reused code into the form.
 */
final class FieldHelper
{
    public static function select()
    {
        /**
         * Credit thanks to Charlie Etienne
         * https://github.com/CharlieEtienne
         */
        return Select::make('prefix_icon')
                ->options(
                    collect(Heroicon::cases())->mapWithKeys(function (Heroicon $heroicon) {
                        $iconName = $heroicon->value;
                        $iconHtml = \Filament\Support\generate_icon_html($heroicon)->toHtml();
                        $label = "<div class='flex gap-2'>$iconHtml<span>$iconName</span></div>";
                        return [$iconName => $label];
                    })->toArray()
                )
                ->searchable()
                ->preload()
                ->allowHtml()
            ->helperText('Choose a Heroicon to prefix the field.');
    }

    public static function customID(string $type)
    {
        $default = $type . uniqid('-');

        return Hidden::make('custom_id')
            ->key('custom_id')
            ->default($default);
    }
}
