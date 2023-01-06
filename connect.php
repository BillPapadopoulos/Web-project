<?php

$conn = mysqli_connect('localhost','root','', 'test');

if(isset($_POST['register'])) {

    $username = $_POST['signupUsername'];
    $emailAddress = $_POST['email'];
    $password =  $_POST['signupPassword'];

 //Database connection

        $duplicate=mysqli_query($conn,"SELECT * FROM user WHERE user_username = '$username' OR email = '$emailAddress'");
        if (mysqli_num_rows($duplicate)>0){

           
            
            echo'<script>
            
            alert("Username or Email already exists.")
            
            </script>';

        }
        else{
            $query = "INSERT INTO user (`user_username`, `email`, `password`) VALUES ('$username', '$emailAddress', '$password')";
            $result = mysqli_query($conn,$query);    
            if($result){
                echo'<script> alert("Successful registration...") </script>';
            }
            else{
                echo'<script>alert("Unsuccessful registration...")</script>';
            }

        }

}

?>