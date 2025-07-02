<?php

namespace Valourite\FormBuilder\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Valourite\FormBuilder\Models\Form;

/**
 * @extends Factory<\Valourite\FormBuilder\Models\Form>
 */
final class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Form::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $formName = fake()->unique()->company();

        return [
            Form::FROM_NAME => $formName,
            Form::FORM_SLUG => Str::slug($formName),
            Form::FORM_DESCRIPTION => fake()->text(255),
            Form::FORM_CONFIRMATION_MESSAGE => fake()->text(255),
            Form::IS_ACTIVE => 1,
            Form::FORM_MODEL => fake()->randomElement(config('form-builder.models')),
            Form::FORM_CONTENT => json_encode(['This is a place holder array' => 'yes']),
            Form::FORM_VERSION => fake()->numberBetween(0, 1).'.'.fake()->numberBetween(0, 5).'.'.fake()->numberBetween(0, 5),
        ];
    }
}
