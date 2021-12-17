<?php

namespace App\Console\Commands;

use App\Models\Media;
use DB;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;

class PurgeMediaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:purge
        {disk=public : the name of the filesystem disk.}
        {--d|directory= : purge files in a given directory.}
        {--non-recursive : only purge files in the specified directory.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unrelated media records and files.';

    /**
     * @var FilesystemManager
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     * @param FilesystemManager $filesystem
     */
    public function __construct(FilesystemManager $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->filesystem = $this->filesystem->disk($this->argument('disk'));

        $this->directory = $this->option('directory');
        $this->recursive = !$this->option('non-recursive');

        $this->deleteRecords();

        $this->deleteFiles();

        $this->deleteEmptyDirectories();
    }

    /**
     * Delete unrelated records.
     *
     * @return void
     */
    protected function deleteRecords()
    {
        $records = Media::inDirectory($this->argument('disk'), $this->directory, $this->recursive)->get();
        $relationRecords = DB::table('mediables')->get();
        $relationRecordIds = $relationRecords->pluck('media_id')->toArray();

        $counter = 0;

        foreach ($records as $model) {
            if (!in_array($model->id, $relationRecordIds)) {
                $model->delete();
                ++$counter;
                $this->info("Purged record for file {$model->getDiskPath()}", 'v');
            }
        }

        $this->info("Purged {$counter} record(s).");
    }

    /**
     * Delete unrelated files.
     *
     * @return void
     */
    protected function deleteFiles()
    {
        $files = $this->filesystem->allFiles($this->directory);

        $counter = 0;

        foreach ($files as $path) {
            if (!Media::whereBasename($path)->exists()) {
                $this->filesystem->delete($path);
                ++$counter;
                $this->info("Purged file {$path}", 'v');
            }
        }

        $this->info("Purged {$counter} file(s).");
    }

    /**
     * Delete empty directories.
     *
     * @return void
     */
    protected function deleteEmptyDirectories()
    {
        $directories = $this->filesystem->allDirectories($this->directory);
        $directories = array_reverse($directories);

        $counter = 0;

        foreach ($directories as $path) {
            if (empty($this->filesystem->listContents($path, $this->recursive))) {
                $this->filesystem->deleteDirectory($path);
                ++$counter;
                $this->info("Purged directory {$path}", 'v');
            }
        }

        $this->info("Purged {$counter} directories.");
    }
}
