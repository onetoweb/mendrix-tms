<?php

namespace Onetoweb\MendrixTms;

use SimpleXMLElement;

/**
 * Utils.
 */
final class Utils
{
    /**
     * @param string $xmlString
     * 
     * @return array
     */
    public static function xml2Array(string $xmlString): array
    {
        /**
         * @param SimpleXMLElement $xml
         * @param array $collection = []
         * 
         * @return array
         */
        $parser = function (SimpleXMLElement $xml, array $collection = []) use (&$parser) {
            
            $nodes = $xml->children();
            
            if ($nodes->count() === 0) {
                
                return strval($xml);
            }
            
            foreach ($nodes as $nodeName => $nodeValue) {
                
                if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                    
                    $collection[$nodeName] = $parser($nodeValue);
                    
                    continue;
                }
                
                $collection[$nodeName][] = $parser($nodeValue);
            }
            
            return $collection;
        };
        
        // get xml
        $xml = new SimpleXMLElement($xmlString);
        
        // build xml array
        $xmlArray = [
            $xml->getName() => $parser($xml)
        ];
        
        return $xmlArray;
    }
}