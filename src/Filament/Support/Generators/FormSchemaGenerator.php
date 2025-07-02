<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

final class FormSchemaGenerator
{
    /**
     * This class will be used to generate and return a schema based on the content that is passed to it.
     */
    public static function formContent(array|string $formContent, array|string $formResponse = []): array
    {
        $formContent  = is_array($formContent) ? $formContent : json_decode($formContent, true);
        $formResponse = is_array($formResponse) ? $formResponse : json_decode($formResponse, true);

        $components = [];

        foreach ($formContent as $section) {
            $fields = [];

            foreach ($section['Fields'] ?? [] as $field) {
                //dd($field);

                $fieldID = $field['custom_id'];

                $name = $field['name'];

                // If we can't find the label, we throw the custom_id as the label
                // This results in a random string as the label
                $label = $field['label'] ?? Str::title($name);

                $type = $field['type'];

                $required = $field['required'] ?? false;

                $prefixIcon = $field['prefix_icon'] ?? null;

                $heroIcon = $prefixIcon ? Heroicon::from($prefixIcon) : null;

                // we need to pass through a unique identifier
                $component = FieldRenderer::render($type, $fieldID);

                $component
                    ->label($label)
                    ->required($required)
                    ->formatStateUsing(fn () => $formResponse[$fieldID] ?? null); // set the default to the value from the form response

                if (self::hasMethod($component, 'prefixIcon')) {
                    $component->prefixIcon($heroIcon);

                    // colour wont work as we need to convert it to tailwind
                    if (self::hasMethod($component, 'prefixIconColor')) {
                        $component->prefixIconColor('white');
                    }
                }

                if (self::hasMethod($component, 'options')) {
                    if (isset($field['options']) && $field['options'] != null) {
                        $component->options(
                            collect($field['options'])->mapWithKeys(fn ($opt) => [
                                $opt['value'] => Str::title(str_replace('_', ' ', $opt['label'])),
                            ])->toArray()
                        );
                    }
                }

                $fields[] = $component;
            }

            // create the section
            if ( ! empty($fields)) {
                $components[] = Section::make($section['title'] ?? 'Section')
                    ->schema($fields)
                    ->collapsible();
            }
        }

        return $components;
    }

    private static function hasMethod(Component $component, string $method): bool
    {
        return method_exists($component, $method);
    }
}
