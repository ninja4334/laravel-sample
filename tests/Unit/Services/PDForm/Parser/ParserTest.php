<?php

use App\Services\PDForm\Parser\Parser;
use App\Services\PDForm\PDForm;

class ParserTest extends TestCase
{
    protected $xmlObject;

    protected $parser;

    public function setUp()
    {
        parent::setUp();

        $pdfFilePath = base_path('tests/stubs/example.pdf');

        $pdForm = new PDForm($pdfFilePath);
        $this->xmlObject = $pdForm->retrieveXmlData();
    }

    public function test_parsing()
    {
        // Act
        $result = Parser::parse($this->xmlObject);

        // Assert
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey(0, $result);

        $this->assertArrayHasKey('size', $result[0]);
        $this->assertArrayHasKey('fields', $result[0]);

        $this->assertArrayHasKey('width', $result[0]['size']);
        $this->assertArrayHasKey('height', $result[0]['size']);

        $this->assertArrayHasKey(0, $result[0]['fields']);

        $this->assertArrayHasKey('type', $result[0]['fields'][0]);
        $this->assertArrayHasKey('name', $result[0]['fields'][0]);
        $this->assertArrayHasKey('value', $result[0]['fields'][0]);
    }

    public function test_getting_page_objects()
    {
        // Arrange
        $parser = new Parser($this->xmlObject);

        // Act
        $pages = $parser->getPages();

        // Assert
        $this->assertNotEmpty($pages);

        foreach ($pages as $page) {
            $this->assertArrayHasKey('size', $page);
            $this->assertArrayHasKey('width', $page['size']);
            $this->assertArrayHasKey('height', $page['size']);
        }
    }

    public function test_getting_field_objects()
    {
        // Arrange
        $parser = new Parser($this->xmlObject);

        // Act
        $fields = $parser->getFields();

        // Assert
        $this->assertNotEmpty($fields);

        foreach ($fields as $field) {
            $this->assertArrayHasKey('id', $field);
            $this->assertArrayHasKey('type', $field);
            $this->assertArrayHasKey('name', $field);
            $this->assertArrayHasKey('value', $field);
            $this->assertArrayHasKey('coordinates', $field);
        }
    }
}