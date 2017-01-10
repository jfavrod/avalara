<?php
namespace Epoque\Avalara;


/**
 * TaxRates
 * 
 * A class for working with Avalara's Tax Rates API.
 *
 * @author Jason McClelland <jason@lakonacomputers.com>
 */

class TaxRates
{
    private $defaults = [
        'url' => 'https://taxrates.api.avalara.com',
        'apikey' => ''
    ];
    
    private $config = [];
    

    public function __construct($spec=[])
    {
        foreach ($this->defaults as $key => $val) {
            $this->config[$key] = $val;
        }
        
        foreach ($spec as $key => $val) {
            if (array_key_exists($key, $this->config)) {
                $this->config[$key] = $val;
            }
        }
    }
    
    
    /**
     * getTotalRate
     * 
     * Get the total tax rate for a give location.
     * 
     * @param stdClass $address Address object contains street, city,
     * state, zip, country.
     * @return string The total tax charge.
     */
    
    public function getTotalRate($address)
    {
        //print_r($address);
        //print_r($subtotal);
        
        $request  = $this->config['url'];
        $request .= ':443/address?';
        $request .= 'street=' . preg_replace('/\s/', '+', $address->street);
        $request .= '&city=' . preg_replace('/\s/', '%20', $address->city);
        $request .= '&state=' . preg_replace('/\s/', '%20', $address->state);
        $request .= '&postal=' . $address->zip;
        $request .= '&country=' . $address->country;
        $request .= '&apikey=' . $this->config['apikey'];
        
        $response = json_decode(file_get_contents($request));
        
        return $response->totalRate;
    }

    
    public function __toString()
    {
        $str = __CLASS__ . " {\n";
        
        foreach ($this->config as $key => $val) {
            $str .= "    $key: $val\n";
        }
        
        return $str . "}\n";
    }
}
