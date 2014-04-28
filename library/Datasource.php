<?php
require_once "InfoList.php";
require_once "Paginator.php";

class Datasource{

    public function remove_datasource(){
        $endpoint = 'delete'.$this->id;
        $response = $this->bridge->get($endpoint);
        return $response;
    }

    public function get_variables($numofvars="ALL"){
        $endpoint = "datasources/".$this->id."/variables";
        $response = $this->bridge->get($endpoint);
        $pag = $this->get_new_paginator($this->bridge, $response, $endpoint);
        $infoList = new InfoList($pag, $numofvars);
        return $infoList->items; 
    }

    public function get_new_paginator($bridge, $response, $endpoint){
        return new Paginator($bridge, $response, $endpoint);
    }

    public function create_variable($data){
        $endpoint = "datasources/".$this->id."/variables";
        $response = $this->bridge->post($endpoint, $data);
        // return "a variable object" 
    }

}

?>