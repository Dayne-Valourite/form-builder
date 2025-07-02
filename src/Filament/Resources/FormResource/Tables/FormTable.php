<?php

namespace Valourite\FormBuilder\Filament\Resources\FormResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Valourite\FormBuilder\Models\Form;

final class FormTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Form::FROM_NAME)
                    ->label('Form Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make(Form::FORM_SLUG)
                    ->label('Slug')
                    ->copyable()
                    ->copyMessage('Slug copied'),

                TextColumn::make(Form::FORM_DESCRIPTION)
                    ->label('Description')
                    ->html()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make(Form::FORM_CONFIRMATION_MESSAGE)
                    ->label('Confirmation Message')
                    ->html()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make(Form::IS_ACTIVE)
                    ->label('Active')
                    ->badge()
                    ->color(fn (bool $state) => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn (bool $state) => $state ? 'Yes' : 'No'),

                TextColumn::make(Form::FORM_MODEL)
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state)),

                TextColumn::make(Form::FORM_VERSION)
                    ->label('Version')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make(Form::IS_ACTIVE)
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),

                SelectFilter::make(Form::FORM_MODEL)
                    ->label('Model')
                    ->options(collect(config('form-builder.models', []))
                        ->mapWithKeys(fn ($model) => [$model => class_basename($model)])),
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
