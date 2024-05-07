<?php

namespace PlatformXMLBuilder;

interface IEstatifyXMLBuilder
{
    /**
     * @param $jsonData
     * @return mixed
     */
    public static function getArrayToXml($data, $xmlData = null);
}