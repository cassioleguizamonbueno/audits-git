<?php


namespace PlatformXMLBuilder;


class XmlToClassConverter
{
    public static function convert($xmlString, $className = 'DynamicClass')
    {
        $classNameTmp = $className;
        $xml = simplexml_load_string($xmlString);

        $classTemplate = "<?php\n\n";
        $classTemplate .= "class $className\n";
        $classTemplate .= "{\n";
        $count = 0;

        foreach ($xml->children()->children() as $element) {
            $propertyName = self::normalizeName($element->getName());
            $propertyType = self::detectType($element);

            if ($propertyName === 'RealState')  {
                $classTemplate .= "    public \$Real = [\n";
                $classTemplate .= "        'Phone' => '$element->RealStatePhone',\n";
                $classTemplate .= "        'Email' => '$element->RealStateEmail'\n";
                $classTemplate .= "    ];\n";
                $count++;
            } else {
                $classTemplate .= "    public \$$propertyName;\n";
            }

        }

        $classTemplate .= "}";

        return $classTemplate;
    }

    private static function normalizeName($name)
    {
        return ucfirst($name);
    }

    private static function detectType($element)
    {
        if ($element->count() > 0) {
            return 'array';
        }

        $value = (string) $element;

        if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
            return 'int';
        }

        if (filter_var($value, FILTER_VALIDATE_FLOAT) !== false) {
            return 'float';
        }

        return 'string';
    }
}
