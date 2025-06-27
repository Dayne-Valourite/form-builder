<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Valourite\FormBuilder\Models\Form;

class FormTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Form::FROM_NAME)
                    ->searchable()
                    ->label('Form Name'),
                TextColumn::make(Form::FORM_SLUG)
                    ->label('Form Slug'),
                TextColumn::make(Form::FORM_DESCRIPTION)
                    ->limit(50)
                    ->searchable()
                    ->label('Form Description'),
                TextColumn::make(Form::FORM_CONFIRMATION_MESSAGE)
                    ->label('Form Confirmation Message')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make(Form::IS_ACTIVE)
                    ->label('Active')
                    ->sortable(),
                TextColumn::make(Form::FORM_MODEL)
                    ->formatStateUsing(fn($record) => class_basename($record->form_model))
                    ->label('Form Model'),
                TextColumn::make(Form::FORM_VERSION)
                    ->label('Form Version'),
            ])
            ->filters([
                //Filter by all active forms
                SelectFilter::make(Form::IS_ACTIVE)
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),

                //Filter by form model
                SelectFilter::make(Form::FORM_MODEL)
                    ->label('Form Model')
                    ->options(config('form-builder.models', [])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
