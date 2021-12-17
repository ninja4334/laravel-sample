<?php

class AppNotificationPresenterTest extends TestCase
{
    public function test_format_date_attribute()
    {
        // Arrange
        $mock = $this->mock('App\Models\AppNotification');
        $presenter = new App\Presenters\AppNotificationPresenter($mock);

        // Act
        $result = $presenter->date('2012/05/05 11:11:11');

        // Assert
        $this->assertEquals('2012-05-05', $result);
    }
}
