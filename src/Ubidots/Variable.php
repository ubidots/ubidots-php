<?php
namespace Ubidots;

class Variable extends ApiObject{

    public $icon;
    public $unit;
    public $raw_datasource;
    public $properties;
    public $values_url;
    public $last_value;
    public $datasource;

    public function __construct($bridge, $data){
        $this->bridge = $bridge;
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->url = $data["url"];
        $this->last_activity = $data["last_activity"];
        $this->tags = $data["tags"];
        $this->description = $data["description"];
        $this->created_at = $data["created_at"];
        $this->icon = $data["icon"];
        $this->unit = $data["unit"];
        $this->raw_datasource = $data["datasource"];
        $this->properties = $data["properties"];
        $this->values_url = $data["values_url"];
        $this->last_value = $data["last_value"];
    }

    public function get_values($numofvals="ALL"){
        $endpoint = "variables/".$this->id."/values";
        $response = $this->bridge->get($endpoint);
        $pag = $this->get_new_paginator($this->bridge, $response, $endpoint);
        $infoList = new InfoList($pag, $numofvals);
        return $infoList->items; 
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
            $this->datasource = $api->get_datasource($id = $this->raw_datasource["id"]);
        }
        return $this->datasource;
    }
}


?>