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
    public static function render(array $fields): Component
    {
        $type = FieldType::tryFrom($fields['type'] ?? 'text');

        return match ($type) {
            FieldType::TEXT => TextInput::make($field['name'] ?? 'Unnamed Field'),
            FieldType::NUMBER => TextInput::make($field['name'] ?? 'Unnamed Field')->numeric(),
            FieldType::PASSWORD => TextInput::make($field['name'] ?? 'Unnamed Field')->password(),
            FieldType::EMAIL => TextInput::make($field['name'] ?? 'Unnamed Field')->email(),
            FieldType::TEXTAREA => Textarea::make($field['name'] ?? 'Unnamed Field'),
            FieldType::SELECT => Select::make($field['name'] ?? 'Unnamed Field'),
            FieldType::RADIO => Radio::make($field['name'] ?? 'Unnamed Field'),
            FieldType::CHECKBOX => Checkbox::make($field['name'] ?? 'Unnamed Field'),
            FieldType::DATE => DatePicker::make($field['name'] ?? 'Unnamed Field'),
            FieldType::TIME => TimePicker::make($field['name'] ?? 'Unnamed Field'),
            FieldType::DATETIME => DateTimePicker::make($field['name'] ?? 'Unnamed Field'),
            FieldType::FILE => FileUpload::make($field['name'] ?? 'Unnamed Field'),
            default => TextInput::make($field['name'] ?? 'Unnamed Field'),
        };
    }
}