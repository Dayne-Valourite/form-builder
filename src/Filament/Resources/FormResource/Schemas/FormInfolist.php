<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Valourite\FormBuilder\Models\Form;

class FormInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make(Form::FROM_NAME),
                TextEntry::make(Form::FORM_SLUG),
                TextEntry::make(Form::FORM_DESCRIPTION),
                TextEntry::make(Form::FORM_CONFIRMATION_MESSAGE),
                TextEntry::make(Form::IS_ACTIVE),
                TextEntry::make(Form::FORM_MODEL),
                TextEntry::make(Form::FORM_VERSION),
            ]);
    }
}
