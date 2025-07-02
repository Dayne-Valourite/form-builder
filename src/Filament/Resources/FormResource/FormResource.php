<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Valourite\FormBuilder\Filament\Resources\FormResource\Pages\CreateForm;
use Valourite\FormBuilder\Filament\Resources\FormResource\Pages\EditForm;
use Valourite\FormBuilder\Filament\Resources\FormResource\Pages\ListForm;
use Valourite\FormBuilder\Filament\Resources\FormResource\Pages\ViewForm;
use Valourite\FormBuilder\Filament\Resources\FormResource\Schemas\FormForm;
use Valourite\FormBuilder\Filament\Resources\FormResource\Schemas\FormInfolist;
use Valourite\FormBuilder\Filament\Resources\FormResource\Tables\FormTable;
use Valourite\FormBuilder\Models\Form;

class FormResource extends Resource
{
    protected static ?string $model = Form::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Schema $schema): Schema
    {
        return FormForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FormInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForm::route('/'),
            'create' => CreateForm::route('/create'),
            'view' => ViewForm::route('/{record}'),
            'edit' => EditForm::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return config('form-builder.grouped', true) ? config('form-builder.group', 'Form Builder') : null;
    }
}
