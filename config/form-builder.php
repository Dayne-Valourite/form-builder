<?php

return [
    /*
     * The prefix of the tables for the form builder.
     */
    'table_prefix' => 'form_builder_',

    /*
     * Indicate if a new record should be created when the current record is edited
     * If false, the version will be updated
     *
     * A new record will only be created if the form fields or section has been updated,
     * this excludes any meta data updates or form description or confirmation message updates
     */
    'create_new_record' => true,

    /*
     * If create_new_record is set to true, versioning will determine how the new version should be created
     * - increment will increment the version value by increment_count
     * - clone will clone the version value
     */
    'versioning' => [
        /*
         * Will increment the version number by the increment_count
         */
        'mode' => 'increment', //or 'clone'
    ],

    /*
     * Determines the step to increment by
     */
    'increment_count' => '0.0.1',

    /*
     * Should add the form builder resources into a navigational group
     */
    'grouped' => true,

    /*
     * The navigational group the resources will fall under
     */
    'group' => 'Form Builder',

    /*
     * A list of all the models on the system that a form can be created for.
     * These models will need to have a form_fields column on them
     */
    'models' => [
        // \App\Models\User::class,
    ],
];
