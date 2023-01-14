<?php 

$con = mysqli_connect('localhost','root','', 'web_database');

$filename = "categories.json";

$data = file_get_contents($filename);

$array = json_decode($data,true);
$inserted_rows=0;
foreach($array as $value){
        $query = "INSERT INTO `subcategory` (`category_id`) VALUES ('".$value['id']."')";
        mysqli_query($con,$query);
        $inserted_rows++;    
};

echo $inserted_rows;
echo "\r\n";
echo "Data inserted In Categories";

?>