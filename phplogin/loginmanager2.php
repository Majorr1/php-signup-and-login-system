<?php

$serverip = 'enter';
$serverusr = 'enter';
$serverpswd = 'enter';
$serverdb = 'enter';

$conn = new mysqli($serverip, $serverusr, $serverpswd, $serverdb);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


if($_POST){

    if($_POST['login']){
        $username = $_POST['name'];
        $password = $_POST['pwd'];

        $sql = "SELECT FROM users * WHERE usersName = '$username' AND usersPwd = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                session_start();
                $_SESSION['username'] = $username;
            }
        } else {
            echo "0 results";
        }
        $conn->close();


    }

    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $uid = $_POST['uid'];

    if($_POST['pwdrepeat'] != $_POST['pwd']){
        echo "The password you entered is not the same!";
        header("Location: /");
    }

    $hashedpswd = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES ('$username', '$email', '$uid', '$hashedpswd')";

    if($conn->query($sql) === TRUE){
        echo "Signup confirmed!";
        header("Location: enter");
    }else{
        echo "There was an error with the signup!" . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}else{
    header("Location: /");
}


?>