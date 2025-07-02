<?php

namespace Valourite\FormBuilder\Filament\Components\Builder;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Component;
use Valourite\FormBuilder\Filament\Enums\FieldType;

class FieldRenderer
{
    public static function render(string $type, ?string $fieldID = null): Component
    {
        $type = FieldType::from(mb_strtolower($type));

        return match ($type) {
            FieldType::TEXT => TextInput::make($fieldID),
            FieldType::NUMBER => TextInput::make($fieldID)->numeric(),
            FieldType::PASSWORD => TextInput::make($fieldID)->password()->revealable(),
            FieldType::EMAIL => TextInput::make($fieldID)->email(),
            FieldType::TEXTAREA => Textarea::make($fieldID),
            FieldType::SELECT => Select::make($fieldID),
            FieldType::RADIO => Radio::make($fieldID),
            FieldType::CHECKBOX => Checkbox::make($fieldID),
            FieldType::DATE => DatePicker::make($fieldID),
            FieldType::TIME => TimePicker::make($fieldID),
            FieldType::DATETIME => DateTimePicker::make($fieldID),
            FieldType::FILE => FileUpload::make($fieldID),
            default => TextInput::make($fieldID),
        };
    }
}
