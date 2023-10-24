<?php

namespace Onetoweb\MendrixTms;

use Twig\Loader\FilesystemLoader;
use Twig\{Environment, TwigFilter};
use DateTime;

/**
 * Twig Loader.
 */
class TwigLoader
{
    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * @param string $content
     *
     * @return string
     */
    public static function formatRequest(string $content): string
    {
        return str_replace(['<', '>'], ['&lt;', '&gt;'], mb_convert_encoding($content, 'UTF-8', 'Windows-1252'));
    }
    
    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function formatValue($value): string
    {
        if ($value instanceof DateTime) {
            return $value->format(DateTime::ATOM);
        }
        
        switch (gettype($value)) {
            
            case 'integer':
            case 'string':
                return $value;
                
            case 'boolean':
                return $value ? 'True' : 'False';
                
            case 'double':
                return rtrim(number_format($value, 10), '0').'0';
                
            default:
                return (string) $value;
        }
    }
    
    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        if ($this->twig === null) {
            
            // setup filesystem loader
            $loader = new FilesystemLoader([__DIR__.'/../templates']);
            
            // get twig environment
            $this->twig = new Environment($loader, [
                'strict_variables' => true
            ]);
            
            // add function
            $this->twig->addFilter(new TwigFilter('format_request', [$this, 'formatRequest']));
            $this->twig->addFilter(new TwigFilter('format_value', [$this, 'formatValue']));
        }
        
        return $this->twig;
    }
}