<?php

use App\Models\Settings;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $key = 'some_value';
    protected $value = 'system@email.com';

    public function setUp()
    {
        parent::setUp();

        factory(\App\Models\Settings::class)->create([
            'name'  => $this->key,
            'value' => $this->value
        ]);
    }

    public function test_getting_value()
    {
        // Arrange
        $settingsModel = Settings::where('name', $this->key)->first();

        $mock = $this->mock('App\Repositories\Contracts\SettingsRepositoryContract');
        $mock->shouldReceive('scopeQuery')->once()->andReturn($mock);
        $mock->shouldReceive('first')->once()->andReturn($settingsModel);

        // Act
        $settings = new SettingsService($mock);
        $result = $settings->get($this->key);

        // Assert
        $this->assertEquals($result, $this->value);
    }

    public function test_failed_getting_by_invalid_name()
    {
        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');

        // Arrange
        $settingsModel = Settings::where('name', 'some_non_existent_value')->first();

        $mock = $this->mock('App\Repositories\Contracts\SettingsRepositoryContract');
        $mock->shouldReceive('scopeQuery')->once()->andReturn($mock);
        $mock->shouldReceive('first')->once()->andReturn($settingsModel);

        // Act
        $settings = new SettingsService($mock);
        $settings->get('some_non_existent_value');
    }
}
