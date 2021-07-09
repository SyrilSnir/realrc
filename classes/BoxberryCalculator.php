<?php

/**
 * Description of BoxberryCalculator
 *
 * @author kotov
 */
class BoxberryCalculator
{
    private $token = "UKTMogKloK3aMIunfToTQO6mdyLDi_qP";
    private $weight = 500;
    private $height = 15;
    private $width = 20;
    private $depth = 10;
    
    private $url;
    private $options;
    
    public function __construct($code, $price)
    {
        $this->url = "http://api.boxberry.ru/json.php?token={$this->token}&method=DeliveryCosts&weight={$this->weight}&target_start=''&target={$code}&ordersum={$price}&deliverysum={$price}&paysum={$price}&height={$this->height}&width={$this->width}&depth={$this->depth}&sucrh=1";
        
        $this->options = [
                'http' => 
                    [                      
                        'method' => 'GET',
                        'header' => 'Content-type: application/json; charset=UTF-8',
                    ]
                ];
    }
    public function calculateShippingPrice()
    {
        $context = stream_context_create($this->options);
        if ($response = file_get_contents($this->url,false,$context)) {
            $result = json_decode($response,true);             
        } else {
            throw new Exception('Boxberry server not allowed');
        }
        if (is_array($result)) {
            $resPrice = round($result['price']);
        }  
        return $resPrice;
    }
}
