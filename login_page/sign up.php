<?php
session_start();
//Database connection
$conn = mysqli_connect('localhost','root','', 'web_database');
//register is the button from the html file
if(isset($_POST['register'])) {
    //get the html id's with method [post]
    $username = $_POST['signupUsername'];
    $emailAddress = $_POST['email'];
    $password =  $_POST['signupPassword'];

 
        //duplicate entries from database
        $duplicate_name=mysqli_query($conn,"SELECT * FROM user WHERE user_username = '$username'");
        $duplicate_email=mysqli_query($conn,"SELECT * FROM user WHERE email = '$emailAddress'");

        // if statement checks if the email or username is already in the database, or else it makes a new register (new user)
        if (mysqli_num_rows($duplicate_name)>0){

           
            
            echo'<script>
            
            alert("This username already exists!");
            window.location.href="Login-Sign up Form.php";
            
            </script>';
            

        }
        else if (mysqli_num_rows($duplicate_email)>0){

            echo'<script>
            
            alert("This email already exists!");
            window.location.href="Login-Sign up Form.php";
            </script>';
       
        
        }
        else{
            $query = "INSERT INTO user (`user_username`, `email`, `password`) VALUES ('$username', '$emailAddress', '$password')";
            $result = mysqli_query($conn,$query);    
            if($result){
                $_SESSION['user_name'] = $username;
                echo'<script> 
                window.location.assign("/web_server/map/map.php");
                alert("Successful registration!");
                 </script>';
            }
            else{
                // preventive error(it never appears)
                echo'<script>alert("Unsuccessful registration...")</script>';
            }

        }

}

?>