<?php

namespace PlatformXMLBuilder;

require_once "vendor/autoload.php";

class RentifyXMLBuilder implements IRentifyXMLBuilder
{


    /**
     * @param $jsonData
     * @return mixed
     */
    public static function getArrayToXml($data, $xmlData = null)
    {
        if ($xmlData === null) {
            $xmlData = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><imoveis/>');
        }

        $flagRentify = true;

        foreach ($data as $key => $value) {
            if ($key === 'publishFor') {
                continue;
            }

            if (is_array($value)) {
                $subNode = $xmlData->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {


                if($flagRentify == true) {

                    $tipo = "";

                    switch ($data['propertyType']) {
                        case 'HOME': $tipo = 'CASA'; break;
                        case 'APARTAMENTO': $tipo = 'APARTAMENTO'; break;
                        case 'LOJA': $tipo = 'LOJA'; break;
                        case 'COBERTURA': $tipo = 'COBERTURA'; break;

                    }

                    $imovel = $xmlData->addChild("imovel");
                    $imovel->addAttribute("dataCriacao", $data['created']);
                    $imovel->addChild('anoConstrucao', $data['buildYear']);
                    $imovel->addChild('contatoTelefone', $data['realStatePhone']);
                    $imovel->addChild('referencia', $data['propertyRefence']);
                    $imovel->addChild('tipoImovel', $tipo);

                    $imovel->addChild('disponibilidade', $data['propertyForSale'] ? 'Venda' : ($data['propertyForRent'] ? 'Locacao' : 'Venda e Locação'));
                    $imovel->addChild('valorVenda', $data['propertySalesPrice']);
                    $imovel->addChild('valorLocacao', $data['propertyRentPrice']);
                    $imovel->addChild('enderecoRua', $data['addressStreet']);
                    $imovel->addChild('enderecoNumero', $data['addressNumber']);
                    $imovel->addChild('enderecoComplemento', $data['addressComplement']);
                    $imovel->addChild('enderecoBairro', $data['addressDistrict']);
                    $imovel->addChild('enderecoCidade', $data['addressCity']);
                    $imovel->addChild('enderecoEstado', $data['addressState']);
                    $imovel->addChild('enderecoPais', $data['addressCountry']);
                    $imovel->addChild('enderecoCEP', $data['addressZipCode']);
                    $flagRentify = false;

                }else{
                  //  $xmlData->addChild($key, htmlspecialchars($value));
                }
            }
        }

        //var_dump($xmlData);

        return $xmlData;
    }
}