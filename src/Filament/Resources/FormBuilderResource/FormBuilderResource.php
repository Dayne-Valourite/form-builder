<?php

namespace Valourite\FormBuilder\Filament\Resources\FormBuilderResource;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Valourite\FormBuilder\Filament\Components\Builder\FormSchemaGenerator;

abstract class FormBuilderResource extends Resource
{
    public static function form(Schema $schema): Schema
    {
        $model = static::getModel();
        $instance = new $model;

        return $schema
            ->components([
                ...static::baseFields(),

                Select::make($instance->getFormIdColumn())
                    ->label('Form')
                    ->relationship('form', 'form_name')
                    ->getOptionLabelsUsing(fn($label) => $label->form_model === $model)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) use ($instance) {
                        $form = \Valourite\FormBuilder\Models\Form::find($state);
                        if ($form) {
                            $set($instance->getFormContentColumn(), $form->form_content);
                            $set($instance->getFormResponseColumn(), []);
                            $set($instance->getFormVersionColumn(), $form->form_version);
                        }
                    }),

                Hidden::make($instance->getFormContentColumn())->dehydrated()->default([]),
                Hidden::make($instance->getFormVersionColumn())->dehydrated()->default([]),

                Group::make()
                    ->schema(fn(callable $get) => FormSchemaGenerator::formContent(
                        $get($instance->getFormContentColumn()) ?? [],
                        $get($instance->getFormResponseColumn()) ?? []
                    ))
                    ->visible(fn(callable $get) => filled($get($instance->getFormContentColumn())))
                    ->reactive()
                    ->columnSpanFull(),

                Hidden::make($instance->getFormResponseColumn())->dehydrated()->default([]),
            ]);
    }

    // Implement this in your resource to define model-specific fields
    public static function baseFields(): array
    {
        return method_exists(static::class, 'customBaseFields')
            ? static::customBaseFields()
            : static::generateFieldsFromModel();
    }

    public static function generateFieldsFromModel(): array
    {
        $modelClass = static::getModel();
        $model = new $modelClass;

        $fields = [];

        foreach ($model->getFillable() as $attribute) {
            if (
                in_array($attribute, [
                    $model->getFormIdColumn(),
                    $model->getFormContentColumn(),
                    $model->getFormResponseColumn(),
                    $model->getFormVersionColumn(),
                    'created_at',
                    'updated_at',
                ])
            )   
                continue;

            $cast = $model->getCasts()[$attribute] ?? null;

            $field = match ($cast) {
                'boolean' => Toggle::make($attribute),
                'integer', 'float', 'decimal' => TextInput::make($attribute)->numeric(),
                'date', 'datetime' => DatePicker::make($attribute),
                'array', 'json' => Textarea::make($attribute),
                default => TextInput::make($attribute),
            };

            $fields[] = $field->label(Str::headline($attribute));
        }

        return $fields;
    }
}
