# Form Builder for Filament & Laravel

**Form Builder** is a Laravel package built on top of [Filament v4](https://filamentphp.com), allowing you to visually build and manage dynamic forms from your admin panel.  
It lets you **attach custom forms to any Eloquent model** in your application with minimal setup.

---

## ✨ Features

- Built with Filament v4 components
- Define forms from your Filament panel UI
- Attach forms to any Laravel model
- Persist form definitions in the database
- All form fields are stored in a single model column
- Supports multiple form versions per model (coming soon)
- Easily extendable and configurable

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

### Step 2: Publish and run migrations

```bash
php artisan vendor:publish --tag=form-builder-config
php artisan migrate
```

### Step 3: Register the plugin in your Filament panel

In your `PanelProvider`:

```php
use Valourite\FormBuilder\FormBuilderPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            FormBuilderPlugin::make(),
        ]);
}
```

---

## 🧩 Usage

1. **Create your own Laravel model**, e.g.:

```php
php artisan make:model Client -m
```

2. **Add a `form_fields` column** to that model's migration:

```php
$table->json('form_fields')->nullable();
```

3. **Configure allowed models** in your `config/form-builder.php`:

```php
'models' => [
    App\Models\Client::class,
    App\Models\Project::class,
],
```

4. **Go to your Filament admin panel** → Navigate to the **Forms** resource → Create a form → Assign it to your model (e.g., `Client`).

5. The form data will be stored in the `form_fields` column on each model instance.

---

## 🧪 Testing & Contributing

Feel free to test, modify, and extend the package!
Pull requests, ideas, and improvements are welcome.

---

## 🚧 Roadmap

* [x] Attach forms to any model
* [ ] Store form definitions in DB
* [ ] Save submissions
* [ ] Multi-page form support
* [ ] Field-level validation and logic
* [ ] Live preview / builder editor

---

## 📄 License

MIT © [Dayne Valourite](https://github.com/dayne-valourite)
