<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class FixStorageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix {--migrate : Migrate files to uploads directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix storage access issues and optionally migrate files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 HIMATEKOM Storage Fix Tool');
        $this->newLine();

        // Check current environment
        $this->info("Environment: " . app()->environment());
        $this->info("Best disk: " . ImageHelper::getBestDisk());
        $this->newLine();

        // Check storage link
        $this->checkStorageLink();

        // Check permissions
        $this->checkPermissions();

        // Test image access
        $this->testImageAccess();

        // Migrate files if requested
        if ($this->option('migrate')) {
            $this->migrateFiles();
        }

        $this->newLine();
        $this->info('✅ Storage fix completed!');
    }

    private function checkStorageLink()
    {
        $this->info('🔍 Checking storage link...');
        
        $publicStoragePath = public_path('storage');
        $storageAppPublic = storage_path('app/public');

        if (is_link($publicStoragePath)) {
            $linkTarget = readlink($publicStoragePath);
            if (realpath($linkTarget) === realpath($storageAppPublic)) {
                $this->line('   ✅ Symbolic link is working correctly');
            } else {
                $this->error('   ❌ Symbolic link points to wrong location');
                $this->line("      Expected: $storageAppPublic");
                $this->line("      Actual: $linkTarget");
            }
        } elseif (is_dir($publicStoragePath)) {
            $this->line('   ℹ️  Storage directory exists (not symbolic link)');
            $this->line('      This is normal for some hosting providers');
        } else {
            $this->error('   ❌ Storage link/directory does not exist');
            
            if ($this->confirm('Create storage link?')) {
                $this->call('storage:link');
            }
        }
    }

    private function checkPermissions()
    {
        $this->info('🔍 Checking permissions...');
        
        $paths = [
            'storage' => storage_path(),
            'storage/app/public' => storage_path('app/public'),
            'public/storage' => public_path('storage'),
            'public/uploads' => public_path('uploads'),
        ];

        foreach ($paths as $name => $path) {
            if (file_exists($path)) {
                $perms = fileperms($path);
                $octal = decoct($perms & 0777);
                $this->line("   $name: $octal");
                
                if (in_array($name, ['storage/app/public', 'public/uploads']) && $octal < '755') {
                    $this->warn("      Permissions may be too restrictive");
                }
            } else {
                $this->line("   $name: ❌ Does not exist");
            }
        }
    }

    private function testImageAccess()
    {
        $this->info('🧪 Testing image access...');
        
        // Test with public disk
        try {
            $testFile = 'test_' . time() . '.txt';
            Storage::disk('public')->put($testFile, 'test content');
            $url = Storage::disk('public')->url($testFile);
            $this->line("   Public disk URL: $url");
            Storage::disk('public')->delete($testFile);
            $this->line('   ✅ Public disk is working');
        } catch (\Exception $e) {
            $this->error('   ❌ Public disk failed: ' . $e->getMessage());
        }

        // Test with uploads disk
        try {
            $testFile = 'test_' . time() . '.txt';
            Storage::disk('uploads')->put($testFile, 'test content');
            $url = Storage::disk('uploads')->url($testFile);
            $this->line("   Uploads disk URL: $url");
            Storage::disk('uploads')->delete($testFile);
            $this->line('   ✅ Uploads disk is working');
        } catch (\Exception $e) {
            $this->error('   ❌ Uploads disk failed: ' . $e->getMessage());
        }
    }

    private function migrateFiles()
    {
        $this->info('📁 Migrating files from storage to uploads...');
        
        if (!$this->confirm('This will copy files from storage/app/public to public/uploads. Continue?')) {
            return;
        }

        $directories = [
            'galleries',
            'posts',
            'divisions/icons',
            'divisions/images',
        ];

        $bar = $this->output->createProgressBar(count($directories));
        $bar->start();

        $totalFiles = 0;
        $migratedFiles = 0;

        foreach ($directories as $dir) {
            $sourceDir = storage_path("app/public/$dir");
            $targetDir = public_path("uploads/$dir");

            if (is_dir($sourceDir)) {
                // Create target directory
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                $files = glob($sourceDir . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $totalFiles++;
                        $filename = basename($file);
                        $targetFile = $targetDir . '/' . $filename;

                        if (!file_exists($targetFile)) {
                            if (copy($file, $targetFile)) {
                                $migratedFiles++;
                            }
                        }
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        
        $this->info("Migration completed:");
        $this->line("   Total files: $totalFiles");
        $this->line("   Migrated: $migratedFiles");
        $this->line("   Skipped: " . ($totalFiles - $migratedFiles));
    }
}