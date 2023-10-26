<?php

namespace Onetoweb\MendrixTms;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Onetoweb\MendrixTms\TwigLoader;
use Onetoweb\MendrixTms\Utils;
use DOMDocument;
use DateTime;

/**
 * Mendrix TMS Api Client.
 */
class Client
{
    /**
     * @var string
     */
    private $baseUrl;
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * @param string $baseUrl
     * @param string $user
     * @param string $password
     */
    public function __construct(string $baseUrl, string $username, string $password)
    {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->password = $password;
        
        $this->setupTwig();
    }
    
    /**
     * @return void
     */
    private function setupTwig(): void
    {
        $this->twig = (new TwigLoader())->getEnvironment();
    }
    
    /**
     * @param string $template
     * @param array $param = []
     * 
     * @return string
     */
    public function getRequestXml(string $template, array $param = []): string
    {
        return $this->twig->render("request/$template.xml.twig", [
            'request' => $param
        ]);
    }
    
    /**
     * @param string $template
     * @param array $param = []
     * 
     * @return string
     */
    public function getXml(string $template, array $param = []): string
    {
        // get request
        $request = $this->getRequestXml($template, $param);
        
        return $this->twig->render('envelope.xml.twig', [
            'username' => $this->username,
            'password' => $this->password,
            'request' => $request
        ]);
    }
    
    /**
     * @param array $data
     * 
     * @return array|null
     */
    public function getOrderIds(array $data): ?array
    {
        $result = $this->soapRequest('get_order_ids', $data);
        
        if (isset($result['EoCustomLinkResponseOrdersNormalIds']['Data']['_TEoListBase_Items']['EoKeyInt'])) {
            
            return array_map(
                function ($item) {
                    return (int) $item['Id'];
                },
                $result['EoCustomLinkResponseOrdersNormalIds']['Data']['_TEoListBase_Items']['EoKeyInt']
            );
        }
        
        return $result;
    }
    
    /**
     * @param array $data
     * 
     * @return array|null
     */
    public function getOrders(array $data): ?array
    {
        $result = $this->soapRequest('get_orders', $data);
        
        if (isset($result['EoCustomLinkResponseOrdersNormal']['Data']['_TEoListBase_Items']['EoOrderMx'])) {
            return $result['EoCustomLinkResponseOrdersNormal']['Data']['_TEoListBase_Items']['EoOrderMx'];
        }
        
        return $result;
    }
    
    /**
     * @param array $data
     * 
     * @return array|null
     */
    public function createOrder(array $data): ?array
    {
        return $this->soapRequest('order', [
            'order' => $data
        ]);
    }
    
    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        $response = $this->soapRequest('datetime');
        
        if (isset($response['EoCustomLinkResponseDateTime']['DateTime'])) {
            return DateTime::createFromFormat(DateTime::ATOM, $response['EoCustomLinkResponseDateTime']['DateTime']);
        }
        
        return null;
    }
    
    /**
     * @param string $name
     * @param array $data = []
     * 
     * @return array|null
     */
    public function soapRequest(string $name, array $data = []): ?array
    {
        $xml = $this->getXml($name, $data);
        
        $response = $this->httpRequest($xml);
        
        return $this->readResponse($response);
    }
    
    /**
     * @param string $response
     * 
     * @return array|null
     */
    public function readResponse(string $response): ?array
    {
        $DOMDocument = DOMDocument::loadXML($response);
        
        $return = $DOMDocument->getElementsByTagName('return')->item(0)->nodeValue;
        
        return Utils::xml2Array($return);
    }
    
    /**
     * @param string $body
     */
    public function httpRequest(string $body): string
    {
        $options = [
            RequestOptions::HEADERS => [
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'urn:UCoSoapDispatcherCustomLink-ICustomLinkSoap#ExecuteRequest'
            ],
            RequestOptions::BODY => $body
        ];
        
        $response = (new GuzzleClient())->post("{$this->baseUrl}/soap/ICustomLinkSoap", $options);
        
        return $response->getBody()->getContents();
    }
}