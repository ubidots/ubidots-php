<?php

require '../vendor/autoload.php';

define('BASE_URL', 'http://app.ubidots.com/api/v1.6/'); 


class ServerBridge{
	
	private $token;
    private $apikey;
    private $apikey_header;

    public function __construct($apikey=null, $token=null, $base_url = null)
  	{
  		$this->base_url = ($base_url) ? $base_url: BASE_URL; 
        if ($apikey){
            $this->token = null;
            $this->apikey = $apikey;
            $this->apikey_header = array(
				'X-UBIDOTS-APIKEY' => $this->apikey
			);
            $this->initialize();
        }elseif ($token){
        	$this->apikey = null;
            $this->token = $token;
            $this->set_token_header();
        }
            
  	}



    private function get_token(){
    	$this->token = json_decode( $this->post_with_apikey('auth/token') )->{'token'};
    	$this->set_token_header();
    }

    private function set_token_header(){
    	$this->token_header = array(
    		'X-AUTH-TOKEN' => $this->token
		);
    }

    public function initialize(){
    	if ($this->apikey){
    		$this->get_token();
    	}
    }

    private function post_with_apikey($path){
    	$headers = $this->apikey_header;
		$request = Requests::post($this->base_url . $path, $headers);
		return $request->body;
    }


}

?>