<?php 

$con = mysqli_connect('localhost','root','', 'web_database');

$filename = "Prices_final.json";

$data = file_get_contents($filename);

$array = json_decode($data,true);
$inserted_rows=0;

foreach($array as $value){
  for($count=0; $count<=4; $count++){
        $query = "INSERT INTO price_variety (`product_id`,`price_date`,`price`) VALUES ('".$value['id']."','".$value['prices'][$count]['date']."','".$value['prices'][$count]['price']."')";
        mysqli_query($con,$query);
        $inserted_rows++;  
  };  
};

echo $inserted_rows;
echo "\r\n";
echo "Data inserted In Prices";

?>