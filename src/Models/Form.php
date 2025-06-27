<?php

namespace Valourite\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
	/**
	* =========================
	*		 TRAIT
	* =========================
	*/

    //---------------------------

	/**
	* =========================
	*		 CONSTANTS
	* =========================
	*/
	
	const FORM_ID                   = 'form_id';
	const FROM_NAME                 = 'form_name';
	const FORM_SLUG                 = 'form_slug';
    const FORM_DESCRIPTION          = 'form_description';
    const FORM_CONFIRMATION_MESSAGE = 'form_confirmation_message';
    const IS_ACTIVE                 = 'is_active';
    const FORM_MODEL                = 'form_model';
    const FORM_CONTENT              = 'form_content';
    const FORM_VERSION              = 'form_version';
	const CREATED_AT                = 'created_at';
	const UPDATED_AT                = 'updated_at';
	const PRIMARY_KEY               = 'form_id';

	/**
	* =========================
	*		 FIELDS
	* =========================
	*/

	protected static string $tableName;
	protected $table;
	protected $primaryKey   = self::PRIMARY_KEY;
	public $incrementing    = true;
	protected $dateFormat   = 'Y-m-d';
	
	/**
	* =========================
	*		 CASTS
	* =========================
	*/

	protected $casts = [
		self::IS_ACTIVE     => 'boolean',
        self::FORM_CONTENT  => 'json',
	];
	
	/**
	* =========================
	*		 FILLABLE
	* =========================
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
     * =======================
     */
    public static function booted(): void
    {
        //This does run

		self::$tableName = config('form-builder.table_prefix') . 'forms';
        
        static::$tableName = config('form-builder.table_prefix') . 'forms';

		//Allow the slug to be generated from the form
		static::creating(function ($model) {
			$model->form_slug = str($model->form_name)->slug();

			$model->form_content ??= json_encode('{}');
		});
    }

	/**
	 * ========================
	 * 		FILAMENT
	 * ========================
	 */

	public function getTable()
	{
		return config('form-builder.table_prefix') . 'forms';
	}
	
	/**
	* =========================
	*		 RELATIONS
	* =========================
	*/

    //--------------------------------

	/**
	* =========================
	*		 FACTORY
	* =========================
	*/

	// public static function factory(): CompanyFactory
	// {
	// 	return CompanyFactory::new();
	// }
}