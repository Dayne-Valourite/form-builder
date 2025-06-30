# 🧩 Laravel Form Builder

A dynamic, schema-driven form builder for Laravel + Filament 4.  
Define flexible forms using JSON. Store responses directly on your model.  
Auto-generate Filament form fields from a saved form structure — no hardcoding required.

---

## 🚀 Features

- 🧱 Build forms using Filament UI components (`TextInput`, `Select`, `DatePicker`, etc.)
- 🔁 Nested sections + fields via repeaters
- 🎨 Customize field labels, types, icons, and layout
- 💾 Store form schema and responses directly on your model
- ⚡ Automatically render fields at runtime based on a selected form
- 🧠 Smart versioning and change detection
- 🔌 Plug-and-play with any Filament resource using a trait and base class

---

## 📦 Installation

```bash
composer require valourite/form-builder
````

Then install the config and run the migration:

```bash
php artisan form-builder:install
```

This will:

* ✅ Publish the config file: `config/form-builder.php`
* ✅ Run the database migrations

You’ll be prompted if files already exist.

---

## 🧰 Usage

### 1. **Set up your model**

Use the `HasFormBuilder` trait:

```php
use Valourite\FormBuilder\Concerns\HasFormBuilder;

class User extends Model
{
    use HasFormBuilder;
}
```

This enables the model to:

* Link to a form (`form_id`)
* Store a schema snapshot (`form_content`)
* Store responses (`form_response`)
* Track the form version (`form_version`)

> These fields are auto-filled — no need to add them to `$fillable`.

---

### 2. **Create a Filament resource**

Use the `FormBuilderResource` base class:

```php
use Valourite\FormBuilder\Filament\Resources\FormBuilderResource;

class UserResource extends FormBuilderResource
{
    protected static string $model = \App\Models\User::class;

    /**
     * Optional: define default fields from your model
     * If omitted, fields will be auto-generated from `$fillable` + `$casts`
     */
    public static function customBaseFields(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ];
    }
}
```

---

### 3. **Use the provided CreatePage**

Instead of writing your own `CreateUser` page, just extend:

```php
use Valourite\FormBuilder\Filament\Pages\FormBuilderCreateRecord;

class CreateUser extends FormBuilderCreateRecord
{
    protected static string $resource = UserResource::class;
}
```

> This handles extracting `form_response` from dynamic fields automatically.

---

## 🧠 Dynamic Form Behavior

* When a user selects a form from the dropdown, the schema is loaded into the form
* Fields are rendered dynamically based on the schema
* Values are saved back into `form_response` using `custom_id` keys
* Form schema changes are supported (fields can be marked `is_active: false`)

---

## ⚙️ Configuration

You can customize the following in `config/form-builder.php`:

```php
return [
    'models' => [
        // Models allowed to use forms
        \App\Models\User::class,
        \App\Models\Project::class,
        \App\Models\Job::class,
    ],

    'versioning' => [
        'mode' => 'increment', // or 'clone'
        'auto_increment' => true,
    ],
];
```

---

## 🧪 Testing

Use Laravel’s built-in testing to assert:

```php
$this->assertDatabaseHas('users', [
    'form_response' => json_encode([...]),
]);
```

---

## 🙌 Credits

Developed by [Valourite](https://github.com/valourite)
Built with ❤️ for Laravel and Filament 4.

---

## 📄 License

MIT License — use it, extend it, build cool stuff with it!
