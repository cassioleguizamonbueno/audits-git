<?php

namespace PlatformXMLBuilder;

interface IRentifyXMLBuilder
{
    /**
     * @param $jsonData
     * @return mixed
     */
    public static function getArrayToXml($data, $xmlData = null);
}