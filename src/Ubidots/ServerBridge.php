<?php
namespace Ubidots;

define('BASE_URL', 'http://things.ubidots.com/api/v1.6/'); 

class ServerBridge{
    
    private $token;
    private $token_header;
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
        $this->token = $this->post_with_apikey('auth/token')['token'];
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
        $headers = $this->prepare_headers($this->apikey_header);
        $request = \Requests::post($this->base_url . $path, $headers);
        return json_decode($request->body, true);
    }

    public function get($path){
        $headers = $this->prepare_headers($this->token_header);
        $request = \Requests::get($this->base_url . $path, $headers);
        return json_decode($request->body, true);
    }
        
    public function get_with_url($url){
        $headers = $this->prepare_headers($this->token_header);
        $request = \Requests::get($url, $headers);
        return json_decode($request->body, true);
    }

    public function post($path, $data){
        $headers = $this->prepare_headers($this->token_header);
        $data = $this->prepare_data($data);
        $request = \Requests::post($this->base_url . $path, $headers, $data);
        return json_decode($request->body, true);
    }

    public function delete($path){
        $headers = $this->prepare_headers($this->token_header);
        $request = \Requests::delete($this->base_url . $path, $headers);
        return json_decode($request->body, true);
    }

    
    private function prepare_headers($headers){
        return array_merge($headers, $this->get_custom_headers());
    }

    private function prepare_data($data){
        return $data;
    }

    private function get_custom_headers(){
        $headers = array(
            'content-type' => 'application/json'
        );
        return $headers;
    }


}

?>
