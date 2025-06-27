<?php

namespace Valourite\FormBuilder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallFormBuilder extends Command
{
    protected $signature = 'form-builder:install';
    protected $description = 'Install the Form Builder package (publish config, run migrations)';

    public function handle(): int
    {
        $this->info('🔧 Installing Form Builder...');

        $this->publishConfigIfNeeded();
        $this->runMigrationsIfNeeded();

        $this->info('🎉 Form Builder installed successfully!');
        return self::SUCCESS;
    }

    protected function publishConfigIfNeeded(): void
    {
        $configPath = config_path('form-builder.php');

        if (File::exists($configPath)) {
            $this->warn('⚠️  Config file already exists: form-builder.php');
            if ($this->confirm('Do you want to overwrite it?', false)) {
                $this->callSilent('vendor:publish', [
                    '--tag' => 'form-builder-config',
                    '--force' => true,
                ]);
                $this->info('✅ Config overwritten');
            } else {
                $this->info('✅ Using existing config');
            }
        } else {
            $this->callSilent('vendor:publish', [
                '--tag' => 'form-builder-config',
            ]);
            $this->info('✅ Config published');
        }
    }

    protected function runMigrationsIfNeeded(): void
    {
        if (Schema::hasTable('form_categories')) {
            $this->warn('⚠️  Migrations already seem to be applied (form_categories table exists)');
            if (! $this->confirm('Do you want to run migrations anyway?', false)) {
                $this->info('⏭️  Skipping migration');
                return;
            }
        }

        $this->call('migrate');
        $this->info('✅ Migrations executed');
    }
}
