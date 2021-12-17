<?php

use App\Services\MediaManager;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Plank\Mediable\Exceptions\MediaUploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaManagerTest extends TestCase
{
    use DatabaseTransactions;

    protected $fileName = 'image.jpg';
    protected $path;
    protected $file;

    public function setUp()
    {
        parent::setUp();

        $this->path = base_path('tests/stubs/' . $this->fileName);

        $this->file = new UploadedFile(
            $this->path,
            $this->fileName,
            filesize($this->path),
            'image/jpg',
            null,
            true
        );
    }

    public function tearDown()
    {
        File::deleteDirectory(public_path('storage/temp'));

        parent::tearDown();
    }

    public function test_uploading_file()
    {
        // Act
        $file = MediaManager::upload($this->file, 'temp');

        // Assert
        $this->assertInstanceOf(\App\Models\Media::class, $file);
        $this->assertEquals($this->fileName, $file->original_filename);
        $this->assertFileExists(public_path('storage/' . $file->getDiskPath()));
    }

    public function test_failed_uploading_by_nonexistent_file()
    {
        // Assert
        $this->expectException(MediaUploadException::class);

        // Act
        MediaManager::upload('some_invalid', 'temp');
    }

    public function test_creating_thumbnail_from_file()
    {
        // Act
        $file = MediaManager::upload($this->file, 'temp');
        $thumbnail = MediaManager::thumbnail($file, 'temp', 'widen', ['width' => 300]);

        // Assert
        $this->assertInstanceOf(\App\Models\Media::class, $thumbnail);
        $this->assertFileExists(public_path('storage/' . $thumbnail->getDiskPath()));
    }

    public function test_getting_original_name()
    {
        // Act
        $originalName = MediaManager::getOriginalName($this->path);

        // Assert
        $this->assertEquals($this->fileName, $originalName);
    }
}
