<?php

namespace Ubidots;

class ApiClient{

    public $bridge;

    public function __construct($apikey=null, $token=null, $base_url = null, $bridge=null){
        if ($bridge){
            $this->bridge = $bridge;
        }else{
            $this->bridge = new ServerBridge($apikey, $token, $base_url);
        }
    }

    public function get_datasources($numofdsources='ALL'){
        $endpoint = "datasources";
        $response = $this->bridge->get($endpoint);
        $pag = new Paginator($this->bridge, $response, $endpoint);
        $infoList = new InfoList($pag, $numofdsources);
        return $this->transform_to_datasource_objects($infoList->items);
    }

    public function get_datasource($id = null){
        $endpoint = "datasources/".$id;
        $response = $this->bridge->get($endpoint);
        return new Datasource($this->bridge, $response);
    }

    public function create_datasource($data){
        $endpoint = "datasources";
        $response = $this->bridge->post($endpoint, $data);
        return new Datasource($this->bridge, $response);
    }

    public function get_variable($id = null){
        $endpoint = "variables/".$id;
        $response = $this->bridge->get($endpoint);
        return new Variable($this->bridge, $response);
    }

     public function get_variables($numofvals="ALL"){
        $endpoint = "variables";
        $response = $this->bridge->get($endpoint);
        $pag = new Paginator($this->bridge, $response, $endpoint);
        $infoList = new InfoList($pag, $numofvals);
        return $this->transform_to_variable_objects($infoList->items);
    }

    private function transform_to_datasource_objects($raw_items){
        $datasources = array();
        foreach ($raw_items as $key => $data) {
            $datasources[$key] = new Datasource($this->bridge, $data);
        }
        return $datasources;
    }

    private function transform_to_variable_objects($raw_items){
        $variables = array();
        foreach ($raw_items as $key => $data) {
            $variables[$key] = new Variable($this->bridge, $data);
        }
        return $variables;
    }
}

?>