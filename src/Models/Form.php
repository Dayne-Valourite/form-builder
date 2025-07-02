<?php

namespace Valourite\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * =========================
     *		 TRAIT
     * =========================.
     */

    //---------------------------

    /**
     * =========================
     *		 CONSTANTS
     * =========================.
     */
    public const FORM_ID = 'form_id';

    public const FROM_NAME = 'form_name';

    public const FORM_SLUG = 'form_slug';

    public const FORM_DESCRIPTION = 'form_description';

    public const FORM_CONFIRMATION_MESSAGE = 'form_confirmation_message';

    public const IS_ACTIVE = 'is_active';

    public const FORM_MODEL = 'form_model';

    public const FORM_CONTENT = 'form_content';

    public const FORM_VERSION = 'form_version';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    public const PRIMARY_KEY = 'form_id';

    public $incrementing = true;

    /**
     * =========================
     *		 FIELDS
     * =========================.
     */
    protected static string $tableName;

    protected $table;

    protected $primaryKey = self::PRIMARY_KEY;

    protected $dateFormat = 'Y-m-d';

    /**
     * =========================
     *		 CASTS
     * =========================.
     */
    protected $casts = [
        self::IS_ACTIVE    => 'boolean',
        self::FORM_CONTENT => 'json',
    ];

    /**
     * =========================
     *		 FILLABLE
     * =========================.
     */
    protected $fillable = [
        self::FROM_NAME,
        self::FORM_SLUG,
        self::FORM_DESCRIPTION,
        self::FORM_CONFIRMATION_MESSAGE,
        self::IS_ACTIVE,
        self::FORM_MODEL,
        self::FORM_CONTENT,
        self::FORM_VERSION,
    ];

    /**
     * =======================
     *      BOOTED
     * =======================.
     */
    public static function booted(): void
    {
        //This does run

        self::$tableName = config('form-builder.table_prefix') . 'forms';

        static::$tableName = config('form-builder.table_prefix') . 'forms';

        //Allow the slug to be generated from the form
        static::creating(function ($model) {
            $model->form_slug = str($model->form_name)->slug();

            if (null === $model->form_content) {
                $model->form_content = json_encode('{}');
            }
            // $processed = collect($model->form_content)->map(function ($section) {
            // 	$section['meta'] = [
            // 		'colour' => $section['colour'] ?? null,
            // 		'icon' => $section['icon'] ?? null,
            // 		'custom_id' => $section['custom_id'] ?? uniqid('sec-'),
            // 	];

            // 	unset($section['colour'], $section['icon'], $section['custom_id']);
            // 	return $section;
            // });

            // $model->form_content = $processed->toArray();

            //Map the form content into the json format
            /*
             * "sections" => {}
             *
             *
             *
             *
             *
             *
             */
        });
    }

    /**
     * ========================
     * 		FILAMENT
     * ========================.
     */
    public function getTable()
    {
        return config('form-builder.table_prefix') . 'forms';
    }

    /*
     * =========================
     *		 RELATIONS
     * =========================
     */

    //--------------------------------

    /*
     * =========================
     *		 FACTORY
     * =========================
     */

    // public static function factory(): CompanyFactory
    // {
    // 	return CompanyFactory::new();
    // }
}
