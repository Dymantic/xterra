<?php


namespace Tests\Unit\Events;


use App\Occasions\Activity;
use App\Occasions\Course;
use App\Occasions\CourseInfo;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class RaceCoursesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_a_course_to_a_race()
    {
        $race = factory(Activity::class)->state('race')->create();

        $course_info = new CourseInfo([
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'distance'    => ['en' => "test distance", 'zh' => "zh test distance"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ]);

        $course = $race->addCourse($course_info);

        $this->assertInstanceOf(Course::class, $course);
        $this->assertEquals(['en' => "test name", 'zh' => "zh test name"], $course->name);
        $this->assertEquals(['en' => "test distance", 'zh' => "zh test distance"], $course->distance);
        $this->assertEquals(['en' => "test description", 'zh' => "zh test description"], $course->description);
    }

    /**
     *@test
     */
    public function can_set_gpx_file_for_a_course()
    {
        Storage::fake('admin_uploads');

        $course = factory(Course::class)->create();
        $file = UploadedFile::fake()->create('test_course.gpx');

        $course->setGPXFile($file);


        Storage::disk('admin_uploads')->assertExists($file->hashName('gpx') . '.gpx');
        $this->assertEquals($file->hashName('gpx') . '.gpx', $course->gpx_filename);
        $this->assertEquals('admin_uploads', $course->gpx_disk);
    }

    /**
     *@test
     */
    public function can_clear_gpx_file()
    {
        Storage::fake('admin_uploads');

        $course = factory(Course::class)->create();
        $course->setGPXFile(UploadedFile::fake()->create('test_course.gpx'));
        $filepath = $course->gpx_filename;

        $course->clearGPXFile();

        Storage::disk('admin_uploads')->assertMissing($filepath);
        $this->assertNull($course->fresh()->gpx_filename);
        $this->assertNull($course->fresh()->gpx_disk);
    }

    /**
     *@test
     */
    public function can_get_url_for_gpx_file()
    {
        Storage::fake('admin_uploads');

        $course = factory(Course::class)->create();
        $file = UploadedFile::fake()->create('test_course.gpx');

        $course->setGPXFile($file);

        $expected = "/{$course->fresh()->gpx_disk}/{$course->fresh()->gpx_filename}";

        $this->assertSame($expected, $course->getGPXFileUrl());
    }

    /**
     *@test
     */
    public function add_image_to_course()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $course = factory(Course::class)->create();

        $image = $course->addImage(UploadedFile::fake()->image('test_pic.jpg'));

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($course->getFirstMedia(Course::IMAGES)->is($image));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }

    /**
     *@test
     */
    public function order_position_of_course_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $course = factory(Course::class)->create();

        $imageA = $course->addImage(UploadedFile::fake()->image('test_picA.jpg'));
        $imageB = $course->addImage(UploadedFile::fake()->image('test_picB.jpg'));
        $imageC = $course->addImage(UploadedFile::fake()->image('test_picC.jpg'));
        $imageD = $course->addImage(UploadedFile::fake()->image('test_picD.jpg'));

        $course->setImagePositions([$imageC->id, $imageB->id, $imageD->id, $imageA->id]);

        $this->assertSame(0, $imageC->fresh()->getCustomProperty('position'));
    }
}
