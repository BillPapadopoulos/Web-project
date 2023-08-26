<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'web_database');

if (isset($_POST['login'])) {

    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    $user = "SELECT * FROM user WHERE user_username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $user);

    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['user_name'] = $username;
        $_SESSION['isAdmin'] = $user_data['isAdmin'];

        if ($user_data['isAdmin'] == 1) {
            if (isset($_POST['loginAsAdmin'])) { // Check if the admin button was clicked
                echo '<script> 
                    alert("Welcome back, admin!");
                    window.location.assign("/web_database/map/admin/admin_dashboard.php");
                </script>';
            } else {
                echo '<script> 
                    alert("Welcome back, user!");
                    window.location.assign("/web_database/map/map.php");
                </script>';
            }
        } else {
            echo '<script> 
                alert("Welcome back, user!");
                window.location.assign("/web_database/map/map.php");
            </script>';
        }
    } else {
        $name_error = "Invalid combination of username/password";
    }
}
?>