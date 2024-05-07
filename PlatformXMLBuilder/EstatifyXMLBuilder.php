<?php


namespace PlatformXMLBuilder;


class EstatifyXMLBuilder implements IEstatifyXMLBuilder
{

    /**
     * @param $jsonData
     * @return mixed
     */
    public static function getArrayToXml($data, $xmlData = null)
    {

        if ($xmlData === null) {
            $xmlData = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><properties/>');
        }

        $propertyRoot = $xmlData->addChild("property");

        $flagProperty = true;
        $flagRealState = true;
        $flagAddress = true;

        foreach ($data as $key => $value) {


            if ($key === 'publishFor') {
                continue;
            }

            if (is_array($value)) {
                $subNode = $propertyRoot->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {

                $arrayProperty = array("propertyRefence", "propertyType", "propertyForSale", "propertyForRent", "propertySalesPrice", "propertyRentPrice", "buildYear");
                $arrayRealState = array("realStatePhone", "realStateEmail");
                $arrayAddress = array("addressStreet", "addressNumber", "addressComplement", "addressDistrict", "addressCity", "addressState", "addressCountry", "addressZipCode");

                if (in_array($key, $arrayProperty)) {
                    if ($flagProperty == true) {

                        $property = $propertyRoot->addChild("property");

                        $property->addChild('year', $data['buildYear']);
                        $property->addChild('ref', $data['propertyRefence']);
                        $property->addChild('type', $data['propertyType']);
                        $property->addChild('forSale', $data['propertyForSale'] ? 'true' : 'false');
                        $property->addChild('forRent', $data['propertyForRent'] ? 'true' : 'false');

                        $price = $property->addChild("price");
                        $price->addChild('sales', $data['propertySalesPrice']);
                        $price->addChild('rent', $data['propertyRentPrice']);

                        $flagProperty = false;
                    }

                } else if (in_array($key, $arrayAddress)) {
                    if ($flagAddress == true) {
                        $realState = $propertyRoot->addChild("realState");
                        $realState->addChild('phone', $data['realStatePhone']);
                        $realState->addChild('email', $data['realStateEmail']);

                        $address = $propertyRoot->addChild("address");
                        $address->addChild('street', $data['addressStreet']);
                        $address->addChild('number', $data['addressNumber']);
                        $address->addChild('complement', $data['addressComplement']);
                        $address->addChild('district', $data['addressDistrict']);
                        $address->addChild('city', $data['addressCity']);
                        $address->addChild('state', $data['addressState']);
                        $address->addChild('country', $data['addressCountry']);
                        $address->addChild('zipCode', $data['addressZipCode']);
                        $flagAddress = false;
                    }

                } else if (in_array($key, $arrayRealState)) {
                    if ($flagRealState == true) {
                        $realState = $propertyRoot->addChild("realState");
                        $realState->addChild('phone', $data['realStatePhone']);
                        $realState->addChild('email', $data['realStateEmail']);
                        $flagRealState = false;
                    }

                } else {
                    $propertyRoot->addChild($key, htmlspecialchars($value));
                }
            }
        }

        //var_dump($xmlData);

        return $xmlData;
    }
}