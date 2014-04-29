<?php
namespace Ubidots;

class Datasource extends ApiObject{

    public $owner;
    public $parent;
    public $context;
    public $variables_url;
    public $number_of_variables;

    public function __construct($bridge, $data){
        $this->bridge = $bridge;
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->url = $data["url"];
        $this->last_activity = $data["last_activity"];
        $this->tags = $data["tags"];
        $this->description = $data["description"];
        $this->created_at = $data["created_at"];
        $this->owner = $data["owner"];
        $this->parent = $data["parent"];
        $this->context = $data["context"];
        $this->variables_url = $data["variables_url"];
        $this->number_of_variables = $data["number_of_variables"];
    }

    public function remove_datasource(){
        $endpoint = 'datasources/'.$this->id;
        $response = $this->bridge->delete($endpoint);
        return $response;
    }

    public function get_variables($numofvals="ALL"){
        $endpoint = "datasources/".$this->id."/variables";
        $response = $this->bridge->get($endpoint);
        $pag = new Paginator($this->bridge, $response, $endpoint);
        $infoList = new InfoList($pag, $numofvals);
        return $this->transform_to_variable_objects($infoList->items);
    }

    private function transform_to_variable_objects($raw_items){
        $variables = array();
        foreach ($raw_items as $key => $data) {
            $variables[$key] = new Variable($this->bridge, $data);
        }
        return $variables;
    }

    public function create_variable($data){
        $endpoint = "datasources/".$this->id."/variables";
        $response = $this->bridge->post($endpoint, $data);
        return new Variable($this->bridge, $response);
    }

}

?>