<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MigrateAll extends Command
{
    protected $signature = 'migrate:all';

    protected $description = 'Run migrations from all folders';

    public function handle()
    {
        // Ruta raíz para la carpeta de migraciones
        $main_folder = database_path('migrations');

        // Ruta para todos los directorios de migraciones
        $sub_folders = File::directories($main_folder);

        $folders_paths = array_merge([$main_folder], $sub_folders);
        $folders_with_relative_path = array_map(fn ($item) => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $item), $folders_paths);

        foreach ($folders_with_relative_path as $folder_with_relative_path) {
            Artisan::call('migrate', ['--path' => $folder_with_relative_path, '--force' => true]);
            $this->line($folder_with_relative_path);
            $this->line(Artisan::output());
        }
    }
}
