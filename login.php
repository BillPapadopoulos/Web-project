<?php

//Database connection
$conn = mysqli_connect('localhost','root','', 'web_database');

if(isset($_POST['login'])) {

  $username=$_POST['loginUsername'];
  $password=$_POST['loginPassword'];

  //the query is saved in a variable and the result gets checked for the number rows
  
  /*$user_name="SELECT * FROM user WHERE user_username = '$username'";
  $user_password=mysqli_query($conn,"SELECT * FROM user WHERE password = '$password'");*/

 $user="SELECT * FROM user WHERE user_username = '$username' AND password = '$password'";

 $result=mysqli_query($conn,$user);

  //if statements checks if user already exists in the database or not.
  //if not the error is printed using php through the html file (name error)

  if (mysqli_num_rows($result)){

  //redirection to map file after the login

   echo'<script> 
   alert("Welcome back!");
   window.location.assign("map.php");
   </script>';
   

  }
  else if(mysqli_num_rows($result)==0){
    //checks if the username or password is empty, 
    //checks if the username exists in the database and the password is wrong
    //checks if the password exists in the database and the username is wrong
    $name_error = "Invalid combination of username/password";
  }
  
}

?>