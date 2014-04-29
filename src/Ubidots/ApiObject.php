<?php
namespace Ubidots;

abstract class ApiObject{

    protected $bridge;
    protected $id;
    protected $name;
    protected $url;
    protected $last_activity;
    protected $tags;
    protected $description;
    protected $created_at;


    public function get_new_paginator($bridge, $response, $endpoint){
        return new Paginator($bridge, $response, $endpoint);
    }
}

?>