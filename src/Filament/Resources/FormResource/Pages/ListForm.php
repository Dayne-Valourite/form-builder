<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Valourite\FormBuilder\Filament\Resources\FormResource\FormResource;

class ListForm extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
