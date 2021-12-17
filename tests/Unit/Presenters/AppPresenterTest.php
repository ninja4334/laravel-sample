<?php

class AppPresenterTest extends TestCase
{
    public function test_generating_application_link()
    {
        // Arrange
        $mock = $this->mock('App\Models\App');
        $mock->shouldReceive('getAttribute')
            ->once()
            ->with('id')
            ->andReturn(1);
        $presenter = new App\Presenters\AppPresenter($mock);

        // Act
        $result = $presenter->link();

        // Assert
        $this->assertEquals(url(config('app.apps_url') . '/1'), $result);
    }

    public function test_format_renewal_date_attribute()
    {
        // Arrange
        $mock = $this->mock('App\Models\App');
        $presenter = new App\Presenters\AppPresenter($mock);

        // Act
        $result = $presenter->renewal_date('2012/05/05 11:11:11');

        // Assert
        $this->assertEquals('2012-05-05', $result);
    }
}
