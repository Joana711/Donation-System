<?php

include_once "../classes/class.user.php";
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
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

  <nav>
    <ul>
      <li><a href="admin.php">Home</a></li>
      <li><a href="admin.donation.php">Donations</a></li>
      <li><a href="admin.users.php">Users</a></li>
      <li><a href="../main/logout.php" class="right">Log out</a></li>
      <li><a href="" class="donate-button"><?php echo $user->get_user_lastname($user_id).', '.$user->get_user_firstname($user_id);?></a></li>
    </ul>
  </nav>

  <div class="hero-image">
  </div>
  
  <div class="content">
      <center><div class="contented">
        <h1>Welcome, Admin!</h1>
        <p>Thank you for logging in. As an admin, you have access to special privileges and features that allow you to manage and control various aspects of the system.</p>
        <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
        <p>Enjoy your admin privileges!</p>
      </div></center>
  </div>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</html>