# Form Builder for Filament & Laravel

**Form Builder** is a Laravel package built on top of [Filament v4](https://filamentphp.com), allowing you to visually build and manage dynamic forms from your admin panel.  
It lets you **attach custom forms to any Eloquent model** in your application with minimal setup.

---

## ✨ Features

- 🔧 Built entirely with Filament v4 components
- 🧠 Dynamic form rendering using `form_content` + `form_response`
- 📥 All form fields are stored in a **single JSON column**
- 🧱 Visually design sections + fields with nested repeaters
- 🌀 Automatically bind values via `custom_id`
- 🧬 Smart versioning support (`form_version`)
- 🧩 Seamlessly plug into any Eloquent model using a trait
- 🛠️ Custom Filament resource base for auto-form handling
- 📦 Install via `form-builder:install` command

---

## 📦 Installation

> Requires Laravel 11+ and Filament 4+

### Step 1: Install via Composer

```bash
composer require dayne-valourite/form-builder
````

> Or, if you’re developing locally:

```bash
composer require dayne-valourite/form-builder --dev
```

### Step 2: Run the installer

```bash
php artisan form-builder:install
```

This will:

* ✅ Publish the config file to `config/form-builder.php`
* ✅ Run the required database migrations

---

## 🔌 Register the plugin

In your `PanelProvider`:

```php
use Valourite\FormBuilder\FormBuilderPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FormBuilderPlugin::make(),
        ]);
}
```

---

## 🧩 Usage

### 1. ✅ Setup your Eloquent model

Use the `HasFormBuilder` trait:

```php
use Valourite\FormBuilder\Concerns\HasFormBuilder;

class Client extends Model
{
    use HasFormBuilder;
}
```

This enables:

* `form_id`
* `form_content`
* `form_response`
* `form_version`

> No need to add these to `$fillable`.

Note: Ensure your model has those columns
- We can update the column names by implementing the following functions:

```php
public static function getFormContentColumn(): string

public static function getFormIdColumn(): string

public static function getFormResponseColumn(): string

public static function getFormVersionColumn(): string
```

---

### 2. ✅ Create a resource using the base class

```php
use Valourite\FormBuilder\Filament\Resources\FormBuilderResource;

class ClientResource extends FormBuilderResource
{
    protected static string $model = \App\Models\Client::class;

    /**
     * Optional: Define your base schema fields
     * If omitted, these will be auto-generated from `$fillable` and `$casts`
     */
    public static function customSchemaFields(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ];
    }

    /**
     * Optional: Define yopur base infolist schema fields
     * If omitted. these will be auto-generated from `$fillable` and `$casts`
     */
    public static function customInfolistFields(): array
    {
        return [
            TextEntry::make('name'),
            TextEntry::make('email'),
        ];
    }
}
```

---

### 3. ✅ Use the base page class

```php
use Valourite\FormBuilder\Filament\Pages\FormBuilderCreateRecord;
use Valourite\FormBuilder\Filament\Pages\FormBuilderEditRecord;

class CreateClient extends FormBuilderCreateRecord
{
    protected static string $resource = ClientResource::class;
}

class EditClient extends FormBuilderEditRecord
{
    protected static string $resource = ClientResource::class;
}
```

This handles:

* Dynamic rendering of the form schema
* Saving the form response into `form_response`
* Linking the correct `form_id`, version, and structure

---

## 🧠 How It Works

* Selecting a form from the dropdown dynamically renders its fields
* Values are bound using each field’s `custom_id`
* Saved response values are stored as `form_response[field_id] => value`
* `form_content` is stored alongside the record for replay/version safety

---

## ⚙️ Configuration

In `config/form-builder.php`:

```php
return [
    'models' => [
        App\Models\Client::class,
        App\Models\Project::class,
    ],

    'versioning' => [
        'mode' => 'increment', // or 'clone'
        'auto_increment' => true,
    ],
];
```

---

## 🧪 Testing & Contributing

Pull requests, issues, and improvements are welcome!

To test form saving logic:

```php
$this->assertDatabaseHas('clients', [
    'form_response' => json_encode([...]),
]);
```

---

## 🚧 Roadmap

* [x] Attach forms to any model
* [x] Store form definitions in DB
* [x] Save submissions as JSON
* [x] Versioning support (increment/clone)
* [ ] Multi-page/wizard forms
* [ ] Conditional logic & rules
* [ ] Drag-and-drop field builder
* [ ] Frontend form rendering (Livewire/Inertia)

---

## 📄 License

MIT © [Dayne Valourite](https://github.com/dayne-valourite)

