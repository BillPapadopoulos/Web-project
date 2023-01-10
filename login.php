<?php


$conn = mysqli_connect('localhost','root','', 'test');

if(isset($_POST['login'])) {

  $username=$_POST['loginUsername'];
  $password=$_POST['loginPassword'];



 //Database connection

 /*$user_name="SELECT * FROM user WHERE user_username = '$username'";
 $user_password=mysqli_query($conn,"SELECT * FROM user WHERE password = '$password'");*/

 $user="SELECT * FROM user WHERE user_username = '$username' AND password = '$password'";

 $result=mysqli_query($conn,$user);



  if (mysqli_num_rows($result)){

   echo'<script> alert("Welcome back!") </script>';

    // header for map
  }
  else if(mysqli_num_rows($result)==0){
    $name_error = "Sorry...Username does not exist";

    


  
  }


}

?>