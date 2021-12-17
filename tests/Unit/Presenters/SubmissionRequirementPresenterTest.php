<?php

class SubmissionRequirementPresenterTest extends TestCase
{
    public function test_formatting_passed_at_attribute()
    {
        // Arrange
        $mock = $this->mock('App\Models\SubmissionRequirement');
        $presenter = new App\Presenters\SubmissionRequirementPresenter($mock);

        // Act
        $result = $presenter->passed_at('2012/05/05 11:11:11');

        // Assert
        $this->assertEquals('2012-05-05', $result);
    }
}
