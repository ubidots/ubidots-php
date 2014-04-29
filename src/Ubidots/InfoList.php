<?php
namespace Ubidots;

class InfoList{

    public $paginator;
    public $items_in_server;

    public function __construct($paginator, $numofitems='ALL'){
        $this->paginator = $paginator;
        $this->items_in_server = $paginator->count;
        $this->items = $this->get_items($numofitems);
    }

    public function get_items($numofitems){
        if(is_numeric($numofitems)){
            return $this->paginator->get_last_items($numofitems);
        }else{
            return $this->paginator->get_all_items();
        }
    }
}

?>
