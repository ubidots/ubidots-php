<?php
require_once "ApiClient.php";
require_once "InfoList.php";
require_once "Paginator.php";

class Variable{

    public function get_values($numofvals="ALL"){
        $endpoint = "variables/".$this->id."/values";
        $response = $this->bridge->get($endpoint);
        $pag = $this->get_new_paginator($this->bridge, $response, $endpoint);
        $infoList = new InfoList($pag, $numofvals);
        return $infoList->items; 
    }

    public function get_new_paginator($bridge, $response, $endpoint){
        return new Paginator($bridge, $response, $endpoint);
    }

    public function save_value($data){
        $endpoint = "variables/".$this->id."/values";
        return $this->bridge->post($endpoint, $data);
    }

    public function save_values($data, $force=false){
        $endpoint = "variables/".$this->id."/values";
        if($force == true){
            $endpoint .= "?force=true";
        }
        return $response = $this->bridge->post($endpoint, $data);
    }

    public function remove_variable(){
        $endpoint = "variables/".$this->id;
        return $this->bridge->delete($endpoint);
    }

    public function get_datasource(){
        if(!$this->datasource){
            $api = new ApiClient(null, null, null, $bridge = $this->bridge);
            $this->datasource = $api->get_datasource(null, $url = $this->datasource_url);
        }
        return $this->datasource;
    }
}


?>