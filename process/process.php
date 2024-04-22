<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "group12";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $firstname = $_POST['userfirstname'];
    $lastname = $_POST['userlastname'];
    $email = $_POST['useremail'];
    $access = $_POST['access'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (user_firstname, user_lastname, user_email, user_access, user_password) VALUES ('$firstname', '$lastname', '$email', '$access', '$password')";

    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("location: ../index.php");
}
?>
