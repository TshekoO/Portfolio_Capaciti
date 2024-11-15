<?php 
session_start();

$username = "";
$email = "";
$age ="";
$errors = array();

$con = mysqli_connect('localhost','root','','onyx') or die("Couldnt connect");

if(isset($_POST['Register'])){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    if(empty($username)) { array_push($errors, "Username is required"); }
    if(empty($email)) { array_push($errors, "Email is required"); }
    if(empty($password))  {array_push($errors,"Password is required"); }

    $user_check_query = "SELECT * FROM users WHERE username ='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($con, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if($user){
        if($user['username'] === $username) {
            array_push($errors, "Username already exists");

        }
    if($user['email'] === $email) {
        array_push($errors, "email already exists");
    }
    }

    if (count($errors) == 0){
        $query = "INSERT INTO users(username,email,age,password)
        VALUES('$username', '$email','$age','$password')";
    mysqli_query($con,$query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: homepage.php');
    }
}
if(isset($_POST['Login'])) {
    $username =mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

if(empty($username)){
    array_push($errors, "Email is required");

}
if(empty($password)){
    array_push($errors, "Password is required");

}
if(count($errors) == 0) {
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($con, $query);
if(mysqli_num_rows($results) == 1) {
    $_SESSION['username'] =$username; 
    $_SESSION['success'] = "You are now logged in";
    header('location: homepage.php');

}else{
    array_push($errors,"Wrong username/password combination");
}
}
}
?>