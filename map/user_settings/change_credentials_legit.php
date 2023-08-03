<?php
session_start();
//establish connection with database
    $conn = mysqli_connect('localhost','root','', 'web_database');

    //take the username and the password of the logged in user
    $updatedusername = $_REQUEST['updatedUsername'];
    $updatedpassword = $_REQUEST['updatedPassword'];

    $oldusername = $_SESSION['user_name']; //take the old username of the user
    $sql = "select * from user where user_username = '$oldusername'";  

    if($updatedusername == ""){    //update password only
      $updatedsql = "UPDATE `user` SET `password`='$updatedpassword' WHERE `user_username`='$oldusername'";
   
      if(mysqli_query($conn, $updatedsql)){
          header('Location: /web_database/map/user_settings/settings.php');
          
      } 
    }
    else if($updatedpassword == ""){   //update username only
      $updatedsql = "UPDATE `user` SET `user_username`='$updatedusername' WHERE `user_username`='$oldusername'";
   
      if(mysqli_query($conn, $updatedsql)){
        $_SESSION['user_name'] = $updatedusername;  // Update the session variable
        header('Location: /web_database/map/user_settings/settings.php');   
      }
    }
    else if($updatedusername!="" && $updatedpassword!=""){    //updating username and password
      $updatedsql = "UPDATE `user` SET `password`='$updatedpassword', `user_username`='$updatedusername' WHERE `user_username`='$oldusername'";
   
      if(mysqli_query($conn, $updatedsql)){
        $_SESSION['user_name'] = $updatedusername;  // Update the session variable
        header('Location: /web_database/map/user_settings/settings.php');
      }
    }
   

?>