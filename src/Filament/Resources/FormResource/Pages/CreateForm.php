<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Valourite\FormBuilder\Filament\Resources\FormResource\FormResource;

class CreateForm extends CreateRecord
{
    protected static string $resource = FormResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd($data);
        //return $data;
    }
}
