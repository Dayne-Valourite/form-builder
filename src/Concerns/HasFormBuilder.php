<?php

namespace Valourite\FormBuilder\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Valourite\FormBuilder\Models\Form;

trait HasFormBuilder
{
    /**
     * This will be attached to models that make use of forms.
     *
     * Abstract function they will need to implement:
     * - form_content field name
     * - form_id field name
     * - form_response field name
     * - form_version field name
     *
     * If a model has this trait then they will have a custom resource rendered for them
     */
    public static function getFormContentColumn(): string
    {
        return 'form_content';
    }

    public static function getFormIdColumn(): string
    {
        return 'form_id';
    }

    public static function getFormResponseColumn(): string
    {
        return 'form_response';
    }

    public static function getFormVersionColumn(): string
    {
        return 'form_version';
    }

    public static function getFormColumns(): array
    {
        return [
            static::getFormContentColumn(),
            static::getFormIdColumn(),
            static::getFormResponseColumn(),
            static::getFormVersionColumn(),
        ];
    }

    public static function bootHasFormBuilder(): void
    {
        static::creating(function (Model $model) {
            static::mergeFormBuilderFillable($model);
        });
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, $this->getFormIdColumn());
    }

    protected static function mergeFormBuilderFillable(Model $model): void
    {
        $columns = static::getFormColumns();

        $existing = $model->getFillable();

        $model->fillable(array_unique(array_merge($existing, $columns)));
    }
}
