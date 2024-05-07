<?php

namespace PlatformXMLBuilder;
use PlatformXMLBuilder\XmlToClassConverter;

class XMLBuilder
{
    /**
     * @param $jsonPath
     * @return void
     */
    public static function fromJson($jsonPath)
    {
        $jsonData = json_decode(file_get_contents($jsonPath), true);
        $publishFor = $jsonData['publishFor'];

        $strFile = explode("/properties/", str_replace(".json", "", $jsonPath))[1];

        foreach ($publishFor as $class) {

            $xmlData = self::getArrayToXml($jsonData, $class);

            $xmlFilePath = 'cache/' . $class . '_'.$strFile.'.xml';
            file_put_contents($xmlFilePath, $xmlData->asXML());


           // self::geraClassPHPToXml($xmlData, $class);

        }
    }

    /**
     * @param $jsonData
     * @return mixed
     */
    public static function getArrayToXml($data, $classname, $xmlData = null)
    {
        if($classname  == "estatify") {
            return EstatifyXMLBuilder::getArrayToXml($data, $xmlData);
        }else if($classname == "rentify") {
            return RentifyXMLBuilder::getArrayToXml($data, $xmlData);
        }
    }

    /**
     * @param $xmlData
     * @param $class
     * Gerador de class php to xml - baseado no xml
     */
    public static function geraClassPHPToXml($xmlData, $class)
    {
        $dynamicClass = XmlToClassConverter::convert($xmlData->asXML(), $class);
        $xmlFilePathClass = 'classes/' . $class . '.php';
        file_put_contents($xmlFilePathClass, $dynamicClass);
        echo $dynamicClass;
    }


}