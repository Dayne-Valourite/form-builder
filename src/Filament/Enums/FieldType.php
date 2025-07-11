<?php

namespace Valourite\FormBuilder\Filament\Enums;

enum FieldType: string
{
    case TEXT     = 'text';
    case NUMBER   = 'number';
    case EMAIL    = 'email';
    case PASSWORD = 'password';
    case TEXTAREA = 'textarea';
    case SELECT   = 'select';
    case RADIO    = 'radio';
    case CHECKBOX = 'checkbox';
    case DATE     = 'date';
    case TIME     = 'time';
    case DATETIME = 'datetime';

    //removed for now as we do not have any upload logic
    //case FILE     = 'file';
}
