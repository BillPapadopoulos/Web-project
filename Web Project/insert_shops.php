
<?php 

$con = mysqli_connect('localhost','root','', 'web_database');

$filename = "shops.json";

$data = file_get_contents($filename);

$array = json_decode($data,true);
$inserted_rows=0;
foreach($array as $value){
    if(isset($value['tags']['name'])){
        $query = "INSERT INTO shop (shop_id,`lat`, lon,`shop_name`) VALUES ('".$value['id']."','".$value['lat']."', '".$value['lon']."','".$value['tags']['name']."')";
        mysqli_query($con,$query);
        $inserted_rows++;
    }else{
        $query = "INSERT INTO shop (shop_id,`lat`, lon) VALUES ('".$value['id']."','".$value['lat']."', '".$value['lon']."')";
        mysqli_query($con,$query);
        $inserted_rows++;
    };
}
echo $inserted_rows;
echo "\r\n";
echo "Data inserted";

?>