<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Valourite\FormBuilder\Filament\Resources\FormResource\FormResource;

final class ViewForm extends ViewRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
