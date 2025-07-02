<?php

namespace Valourite\FormBuilder\Filament\Resources\FormBuilderResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\HtmlString;

abstract class FormBuilderCreateRecord extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $model    = static::getModel();
        $instance = new $model();

        $formResponse = [];

        $formData = $data[$instance->getFormContentColumn()] ?? [];

        foreach ($formData as $section) {
            foreach ($section['Fields'] ?? [] as $field) {
                if (isset($field['custom_id'], $data[$field['custom_id']])) {
                    $formResponse[$field['custom_id']] = $data[$field['custom_id']];
                    unset($data[$field['custom_id']]);
                }
            }
        }

        $data[$instance->getFormResponseColumn()] = json_encode($formResponse);
        $data[$instance->getFormContentColumn()]  = json_encode($formData);

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        $model    = static::getModel();
        $instance = new $model();

        $title = $instance->form_confirmation_message ?? 'Form submitted successfully!';

        return Notification::make()
            ->success()
            ->body(new HtmlString($title))
            ->title('worked');
    }
}
