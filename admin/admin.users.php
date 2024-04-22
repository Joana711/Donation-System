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
    exit();
}
$user_id = $user->get_user_id($_SESSION['user_email']);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        /* The modal (hidden by default) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
        <a href="add.user.php"><button>Add New User</button></a>

        <?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "group12";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT user_id, user_firstname, user_lastname, user_email, user_access FROM users ORDER BY user_id ASC";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo 
                '<table border="1">
                <tr>
                <th>ID              </th>
                <th>First Name      </th>
                <th>Last Name       </th>
                <th>Email address   </th>
                <th>Access          </th>
                <th>Action          </th>
                </tr>'
            ;
                    
            while($row = $result->fetch_assoc()) {
                echo '<tr>
                    <td>'.$row["user_id"].'</td>
                    <td><a href="javascript:void(0);" onclick="showUserDonations('.$row["user_id"].')" style="float: left; text-decoration: underline; color: inherit; background-color: transparent;">'.$row["user_firstname"].'</a></td>
                    <td>'.$row["user_lastname"].'</td>
                    <td>'.$row["user_email"].'</td>
                    <td>'.$row["user_access"].'</td>
                    <td>
                        <a href="?action=delete&id='.$row["user_id"].'">Delete</a>
                        <a href="?action=edit&id='.$row["user_id"].'">Edit</a>
                    </td> 
                    </tr>'
                ;
            }

            echo '</table><br><br>';
        } 
                
        else {
            echo "0 results";
        }

        if ($action == 'edit' && isset($id)) {
            $edit_query = "SELECT user_id, user_firstname, user_lastname, user_email, user_access FROM users WHERE user_id = $id";
            $edit_result = $conn->query($edit_query);
            if ($edit_result->num_rows == 1) {
                $edit_row = $edit_result->fetch_assoc();

                echo '<div class="form-container">
                            <form action="?action=update&id='.$edit_row["user_id"].'" method="POST">
                                <label for="firstname">First Name:</label>
                                <input type="text" name="firstname" value="'.$edit_row["user_firstname"].'"><br>

                                <label for="lastname">Last Name:</label>
                                <input type="text" name="lastname" value="'.$edit_row["user_lastname"].'"><br>

                                <label for="email">Email:</label>
                                <input type="email" name="email" value="'.$edit_row["user_email"].'"><br>

                                <label for="access">Access:</label>
                                <select id="access" name="access">
                                    <option value="admin" '; if ($edit_row["user_access"] == 'admin') echo 'selected'; echo '>Admin</option>
                                    <option value="donator" '; if ($edit_row["user_access"] == 'donator') echo 'selected'; echo '>Donator</option>
                                </select><br>

                                <input type="submit" value="Update">
                            </form>
                        </div><br><br>'; 
            } 
            
            else {
                echo "Record not found.";
            }
        
        }

        if ($action == 'delete' && isset($id)) {
            $delete_query = "DELETE FROM users WHERE user_id = $id";
            if ($conn->query($delete_query) === TRUE) {
                echo "Record deleted successfully";
            } 
            
            else {
                echo "Error deleting record: " . $conn->error;
            }  
            
        }

        if ($action == 'update' && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['access'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $access = $_POST['access'];
            $update_query = "UPDATE users SET user_firstname='$firstname', user_lastname='$lastname', user_email='$email', user_access='$access' WHERE user_id = $id";
            if ($conn->query($update_query) === TRUE) {
                echo "Record updated successfully";
                
            } 
            
            else {
                echo "Error updating record: " . $conn->error;
            }
        }

        function add_user($firstname, $lastname, $email, $access) {
            global $conn;
            $query = "INSERT INTO users (user_firstname, user_lastname, user_email, user_access) VALUES ('$firstname', '$lastname', '$email', '$access')";
            if ($conn->query($query) === TRUE) {
                echo "New record created successfully";
            } 
            
            else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        }
                
        ?>
        <div id="donationModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="donationDetails"></div>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
    function showUserDonations(userId) {
        // AJAX request to fetch donations for the selected user
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Create a popup with the donations table
                var popup = window.open("", "Donations", "width=600,height=400");
                popup.document.write(this.responseText);
            }
        };
        xhttp.open("GET", "user_donations.php?user_id=" + userId, true);
        xhttp.send();
    }
</script>

</body>
</html>