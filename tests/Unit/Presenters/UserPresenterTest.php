<?php

class UserPresenterTest extends TestCase
{
    public function test_generating_full_name_attribute()
    {
        // Arrange
        $mock = $this->mock('App\Models\User');
        $mock->shouldReceive('getAttribute')
            ->twice()
            ->andReturn('John', 'Doe');

        $presenter = new App\Presenters\UserPresenter($mock);

        // Act
        $result = $presenter->full_name();

        // Assert
        $this->assertEquals('John Doe', $result);
    }
}
