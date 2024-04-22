<?php
include_once '../classes/class.user.php';
include '../main/data.php';

$page = $_GET['page'] ?? '';
$subpage = $_GET['subpage'] ?? '';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

$user = new User();
if(!$user->get_session()){
	header("location: ../main/login.php");
}

$user_id = $user->get_user_id($_SESSION['user_email']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $access = $_POST['access'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    $result = $user->new_user($firstname,$lastname,$email,$access,$password,$address);

    if ($result) {
        echo "User added successfully";
    } else {
        echo "Error adding user";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../css/mehi.css">
</head>

<body>
    <div class="intro">
        <h3></h3>
        <h1>New User</h1>
        <p>Please fill up your personal informations.</p>
        <p>Thank you.</p>
        <img src="../css/bye.jpg">
    </div>
    
    <div class="log">

        <form method="POST" action="../process/process.php" name="register">
            <p>Personal Details</p>
            <div>
                <input type="text" class="input" required name="userfirstname" placeholder="First name"/>
            </div>
            <div>
                <input type="text" class="input" required name="userlastname" placeholder="Last name"/>
            </div>
            <div>
                <input type="email" class="input" required name="useremail" placeholder="Email address"/>
            </div>
            <div>
                <select id="access" name="access">
                    <option value="admin">Admin</option>
                    <option value="donator">Donator</option>
                </select>
            </div>
            <div>
                <input type="password" class="input" required name="password" placeholder="Password"/>
            </div>
            <br><br>
            <div>
                <center><input type="submit" name="submit" value="Submit"/></center>
            </div>
        </form>
    </div>
</body>
</html>