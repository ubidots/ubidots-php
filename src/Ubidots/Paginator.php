<?php
namespace Ubidots;

class Paginator{

    public $bridge;
    public $response;
    public $endpoint;
    public $count;
    public $items_per_page;
    public $number_of_pages;
    public $pages;
    public $items;

    public function __construct($bridge, $response, $endpoint){
        $this->bridge = $bridge;
        $this->response = $response;
        $this->endpoint = $endpoint;
        $this->count = $this->response["count"];
        $this->items_per_page = $this->get_number_of_items_per_page();
        $this->number_of_pages = $this->get_number_of_pages();
        $this->pages = $this->custom_range_array(1, $this->number_of_pages);
        $this->items = array();
        $this->add_new_items(1, $response);
    }

    private function custom_range_array($start, $end){
        $arr = array();
        foreach (range($start, $end) as $number) {
            $arr[$number] = $number;
        }
        return $arr;

    }
    private function there_is_more_than_one_page(){
        return (boolean) count($this->response['results']) < $this->count;
    }

    private function get_number_of_items_per_page(){
        return count($this->response['results']);
    }

    private function get_number_of_pages(){
        if ($this->items_per_page == 0){
            return 0;
        }
        $number_of_pages = (int) $this->count/$this->items_per_page;
        if ($this->count%$this->items_per_page !=0){
            $number_of_pages += 1;
        }
        return $number_of_pages;
    }

    public function add_new_items($page, $response){
        $new_items = $response['results'];
        $this->items[$page] = $new_items;

    }


    private function get_page_from_url($url){
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        if(isset($query['page'])){
            return (int) $query['page'];
        }else{
            throw new Exception ("Something got wrong with the url pagination ".$url);
        }

    }

    private function get_page_number($response){
        $prev = $response['previous'];
        $next = $response['next'];

        if(!$prev){
            return 1;
        }else{
            return $this->get_page_from_url($prev) +1;
        }
    }

    public function get_page($page, $force_update=false){

        if(!in_array($page, $this->pages)){
            throw new Exception ("Page Out of Range");
        }
        if(array_key_exists((int) $page, $this->items) && $force_update == false){
            return $this->items[$page];
        }else{
            $response = $this->bridge->get($this->endpoint ."?page=". $page);
            $this->add_new_items($page, $response);
            return $this->items[$page];
        }
    }

    public function get_last_items($number_of_items){
        if($number_of_items == 0){return array();}
        $pages = $this->calculate_pages_needed($number_of_items);
        $this->get_pages($pages);
        $list_of_items = $this->flat_items($pages);
        return array_slice($list_of_items, 0, min($number_of_items, $this->count)); 

    }
    
    public function get_all_items(){
        return $this->get_last_items($this->count);
    }

    private function calculate_pages_needed($number_of_items){
        if($this->count == 0){return array();}
        $num_pages = (int) $number_of_items/$this->items_per_page;
        $res = $number_of_items%$this->items_per_page;
        $one_more_page = 1;
        if ($res){
            return $this->filter_valid_pages($this->custom_range_array(1, $num_pages + 1 + $one_more_page));
        }else{
            return $this->filter_valid_pages($this->custom_range_array(1, $num_pages + 1));
        }
    }

    public function get_pages($pages){
        foreach ($pages as $page) {
            $this->get_page($page);
        }
    }

    private function flat_items($pages){
        $nestedlist = array_intersect_key($this->items, $pages);
        reset($nestedlist);
        return array_values(current($nestedlist));
    }

    private function filter_valid_pages($list_of_pages){
        return array_intersect($list_of_pages, $this->pages);
    }

}

?>