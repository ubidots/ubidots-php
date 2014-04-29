<?php
namespace Ubidots;

require "ApiClient.php";
$api = new ApiClient($apikey="ffe22112fdd1c55f0f3969169f3d3f37b1ad0997");
echo "<pre>";
echo "<h1>vars</h1>";
$ds_all = $api->get_datasources();
$ds = $ds_all[0];

print_r($ds);
$var = $ds->get_variables()[0];

// $data = array("name"=>"Prueba desde cliente 1", "unit"=>"%");
// $var = $ds->create_variable($data));


// echo "<h1>Variables</h1>";
// print_r( $api->get_variables(1));


// $bridge = new ServerBridge($apikey="ffe22112fdd1c55f0f3969169f3d3f37b1ad0997");
// echo count( $bridge->get("datasources")->{"results"});

// $data=array(
// "value"=>22, 
// "timestamp"=>1383497090000
// );

// $bridge->post("variables/530b579a7625423676f3680/values", $data);


// $bridge->delete("variables/535a5f017625427f7ff13b78");
// echo "<br>";
// echo  $bridge->get("datasources")->{"count"};

// $prev = $bridge->get("variables?page_size=10&page=1")->{"next"};
// if($prev){
// 	echo $prev;
// }else{
// 	echo "false";
// }


// $url = 'https://mysite.com/test/1234?page=2&email=xyz2@test.com';
// $parts = parse_url($url);
// parse_str($parts['query'], $query);

// if(isset($query['page'])){
// 	echo gettype($query['page']);
// }

?>