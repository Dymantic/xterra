<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\LaravelLocalization;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asAdmin()
    {
        $admin = factory(User::class)->create();

        return $this->actingAs($admin);
    }

    public function asGuest()
    {
        return $this->assertGuest();
    }

    protected function refreshApplicationWithLocale($locale)
    {
        self::tearDown();
        putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
        self::setUp();
    }

    protected function tearDown(): void
    {
        putenv(LaravelLocalization::ENV_ROUTE_KEY);
        parent::tearDown();
    }

    public function fakeMediaStorage()
    {
        Storage::fake('media', config('filesystems.disks.media'));
    }

    public function assertMediaStorageHas($media, $conversions = [])
    {
        Storage::disk('media')->assertExists(Str::after($media->getUrl(), "/media"));

        collect($conversions)->each(
            fn ($conversion) => Storage::disk('media')->assertExists(Str::after($media->getUrl($conversion), "/media"))
        );
    }

    public function assertMediaStorageMissing($media)
    {
        Storage::disk('media')->assertMissing(Str::after($media->getUrl(), "/media"));
    }


}
