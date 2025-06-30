<?php

namespace Valourite\FormBuilder\Filament\Resources\FormBuilderResource\Pages;

use Filament\Resources\Pages\CreateRecord;

abstract class FormBuilderCreateRecord extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $model = static::getModel();
        $instance = new $model;

        $formResponse = [];

        $formData = $data[$instance->getFormContentColumn()] ?? [];

        foreach ($formData as $section) {
            foreach ($section['Fields'] ?? [] as $field) {
                if (isset($field['custom_id']) && isset($data[$field['custom_id']])) {
                    $formResponse[$field['custom_id']] = $data[$field['custom_id']];
                    unset($data[$field['custom_id']]);
                }
            }
        }

        $data[$instance->getFormResponseColumn()] = json_encode($formResponse);
        $data[$instance->getFormContentColumn()] = json_encode($formData);

        return $data;
    }
}