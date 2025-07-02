<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Valourite\FormBuilder\Filament\Resources\FormResource\FormResource;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();
        $oldContent = is_array($record->form_content) ? $record->form_content : json_decode($record->form_content, true);
        $newContent = is_array($data['form_content']) ? $data['form_content'] : json_decode($data['form_content'], true);

        $shouldCreateNew = config('form-builder.create_new_record');
        $hasChanges = $this->hasFormContentChanged($oldContent, $newContent);

        if ($shouldCreateNew && $hasChanges) {
            $newForm = $record->replicate([
                'form_id',
                'created_at',
                'updated_at',
            ]);

            // Apply versioning
            if (config('form-builder.versioning.mode') === 'increment') {
                $newForm->form_version = $this->incrementVersion(
                    $record->form_version,
                    config('form-builder.increment_count', '0.0.1')
                );
            }

            $newForm->form_content = $newContent;
            $newForm->save();

            // new form has been created, revert the data back to original
            $data['form_content'] = $oldContent;

            // //redirect to the new form view page
            // return redirect(FormResource::getUrl('edit', ['record' => $newForm]));
        } elseif ($hasChanges) {
            // increment form version
            $data['form_version'] = $this->incrementVersion(
                $record->form_version,
                config('form-builder.increment_count', '0.0.1')
            );
        } else {
            // unset as there are not changes
            unset($data['form_content']);
        }

        return $data;
    }

    protected function hasFormContentChanged(array $old, array $new): bool
    {
        // Strip metadata keys that shouldn't trigger a new version
        $normalize = fn (array $content) => array_map(function ($section) {
            unset($section['title'], $section['icon'], $section['colour']);

            if (isset($section['Fields'])) {
                $section['Fields'] = array_map(function ($field) {
                    unset($field['label'], $field['icon'], $field['colour']);

                    return $field;
                }, $section['Fields']);
            }

            return $section;
        }, $content);

        return $normalize($old) !== $normalize($new);
    }

    protected function incrementVersion(string $currentVersion, string $increment = '0.0.1'): string
    {
        [$major, $minor, $patch] = array_map('intval', explode('.', $currentVersion));
        [$incMajor, $incMinor, $incPatch] = array_map('intval', explode('.', $increment));

        $newPatch = $patch + $incPatch;
        $newMinor = $minor + $incMinor;
        $newMajor = $major + $incMajor;

        return "{$newMajor}.{$newMinor}.{$newPatch}";
    }
}
