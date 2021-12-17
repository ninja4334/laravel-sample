<?php

use App\Services\PDForm\PDForm;

class PDFormTest extends TestCase
{
    protected $pdfFilePath;
    protected $imgFilePath;

    public function setUp()
    {
        parent::setUp();

        $this->pdfFilePath = base_path('tests/stubs/example3.pdf');
        $this->imgFilePath = base_path('tests/stubs/image.jpg');
    }

    public function test_parsing_pdf()
    {
        // Arrange
        $pdForm = new PDForm($this->pdfFilePath);

        // Act
        $pages = $pdForm->parse();

        // Assert
        $this->assertNotEmpty($pages);

        foreach ($pages as $page) {
            $this->assertArrayHasKey('size', $page);
            $this->assertArrayHasKey('fields', $page);

            $this->assertArrayHasKey('width', $page['size']);
            $this->assertArrayHasKey('height', $page['size']);

            foreach ($page['fields'] as $field) {
                $this->assertArrayHasKey('type', $field);
                $this->assertArrayHasKey('name', $field);
                $this->assertArrayHasKey('value', $field);
            }
        }
    }

    public function test_retrieving_xml_data()
    {
        // Arrange
        $pdForm = new PDForm($this->pdfFilePath);

        // Act
        $xmlData = $pdForm->retrieveXmlData();

        // Assert
        $this->assertInstanceOf(SimpleXMLElement::class, $xmlData);
    }

    public function test_converting_pdf_file_to_xml_string()
    {
        // Arrange
        $pdForm = new PDForm($this->pdfFilePath);

        // Act
        $xmlString = $pdForm->convertToXml();

        // Assert
        $this->assertStringStartsWith('<pdf>', $xmlString);
    }

    public function test_failed_parse_non_pdf()
    {
        // Assert
        $this->expectException(\App\Services\PDForm\Exceptions\InvalidFileException::class);

        // Arrange
        $pdForm = new PDForm($this->imgFilePath);

        // Act
        $pdForm->parse();
    }

    public function test_filling_pdf_file_by_data()
    {
        // Arrange
        $pdForm = new PDForm($this->pdfFilePath);

        // Act
        $result = $pdForm->merge([]);

        // Assert
        $this->assertFileExists($result);
    }
}