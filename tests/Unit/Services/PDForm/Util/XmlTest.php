<?php

use App\Services\PDForm\Parser\Parser;
use App\Services\PDForm\PDForm;
use App\Services\PDForm\Util\Xml;

class XmlTest extends TestCase
{
    protected $xmlObject;

    public function setUp()
    {
        parent::setUp();

        $pdfFilePath = base_path('tests/stubs/example.pdf');

        $pdForm = new PDForm($pdfFilePath);
        $xmlData = $pdForm->retrieveXmlData();
        $this->xmlObject = $xmlData->xpath(Parser::XPATH_PAGES)[0];
    }

    public function test_getting_xml_object_id()
    {
        // Act
        $id = Xml::getObjectId($this->xmlObject);

        // Assert
        $this->assertInternalType('integer', $id);
        $this->assertGreaterThan(0, $id);
    }

    public function test_getting_xml_object_by_id()
    {
        // Act
        $id = Xml::getObjectId($this->xmlObject);
        $object = Xml::getObjectById($this->xmlObject, $id);

        // Assert
        $this->assertInstanceOf(SimpleXMLElement::class, $object);
    }

    public function test_getting_xml_object_value_by_key()
    {
        // Act
        $result = Xml::getValueByKey($this->xmlObject, 'Count');

        // Assert
        $this->assertNotEmpty($result);
        $this->assertArraySubset(['number' => 2], $result);
    }

    public function test_converting_xml_object_to_array()
    {
        // Act
        $result = Xml::convertToArray($this->xmlObject);

        // Assert
        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result);
    }

    public function test_getting_dict_attributes_from_array()
    {
        // Act
        $array = Xml::convertToArray($this->xmlObject);
        $result = Xml::getDictAttributes($array);

        // Assert
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('Count', $result);
        $this->assertArrayHasKey('MediaBox', $result);
    }
}