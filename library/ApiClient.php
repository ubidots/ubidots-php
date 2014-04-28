<?php
include_once "ServerBridge.php";
include_once "Paginator.php";
include_once "InfoList.php";


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
        return $infoList->items;
    }
}


?>