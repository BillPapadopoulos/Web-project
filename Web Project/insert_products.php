<?php 

$con = mysqli_connect('localhost','root','', 'web_database');

$filename = "Products_final.json";

$data = file_get_contents($filename);

$array = json_decode($data,true);
$inserted_rows=0;
foreach($array as $value){
        $query = "INSERT INTO product (`product_id`, `product_name`,`category_id`,`subcategory_id`) VALUES ('".$value['id']."','".$value['name']."','".$value['category']."','".$value['subcategory']."')";
        mysqli_query($con,$query);
        $inserted_rows++;    
};

echo $inserted_rows;
echo "\r\n";
echo "Data inserted In Products";

?>