<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

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
        return Select::make('prefix_icon')
            ->label('Prefix Icon')
            ->options(
                collect(Heroicon::cases())
                    ->mapWithKeys(fn ($icon) => [
                        $icon->value => Str::title(str_replace('-', ' ', $icon->value)),
                    ])
                    ->toArray()
            )
            ->searchable()
            ->helperText('Choose a Heroicon to prefix the field.');
    }
}
