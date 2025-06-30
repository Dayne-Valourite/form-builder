<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class FormSchemaGenerator
{
    /**
     * This class will be used to generate and return a schema based on the content that is passed to it
     */

    public static function formContent(array $formContent, array $formResponse = []): array
    {
        $components = [];

        foreach($formContent as $section) {
            
            $fields = [];

            foreach($section['Fields'] ?? [] as $field) {
                
                //This would cause an issue if we can't find the field ID and we try set one
                //The issue is that we depend on that field ID for future changes to the form
                //Remove a field id from being created --> rather error
                //$fieldID = $field['custom_id'] ?? uniqid('field-');
                $fieldID = $field['custom_id'];

                $name = $field['name'];

                //If we can't find the label, we throw the custom_id as the label
                //This results in a random string as the label
                $label = $field['label'] ?? Str::title($name);

                $type = $field['type'];

                $prefixIcon = $field['prefix_icon'] ?? null;

                $heroIcon = $prefixIcon ? Heroicon::from($prefixIcon) : null;

                $colour = $field['colour'] ?? null;

                //we need to pass through a unique identifier
                $component = FieldRenderer::render($type, $fieldID);

                $component
                    ->label($label)
                    //->prefixIcon($prefix_icon);
                    ->prefixIcon($heroIcon)
                    ->prefixIconColor('text-gray-400');
                    //->colour($colour);

                $fields[] = $component;
            }

            //create the section
            if(!empty($fields))
            {
                $components[] = Section::make($section['title'] ?? 'Section')
                    ->schema($fields)
                    ->collapsible();
            }
        }

        return $components;
    }
}