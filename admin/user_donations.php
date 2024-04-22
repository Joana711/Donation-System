<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        th:first-child, td:first-child {
            width: 10%;
        }

        th:nth-child(2), td:nth-child(2) {
            width: 20%;
        }

        th:nth-child(3), td:nth-child(3) {
            width: 30%;
        }

        th:last-child, td:last-child {
            width: 40%;
        }

        .total-amount {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
<?php
// Assuming you've included necessary files and setup database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "group12";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is provided in the URL
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch user's information
    $user_query = "SELECT user_firstname, user_lastname FROM users WHERE user_id = $user_id";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows == 1) {
        $user_row = $user_result->fetch_assoc();
        $user_firstname = $user_row["user_firstname"];
        $user_lastname = $user_row["user_lastname"];

        // Display user's donations
        echo "<h2>Donations for $user_firstname $user_lastname:</h2>";

        $donations_query = "SELECT * FROM donations WHERE user_id = $user_id";
        $donations_result = $conn->query($donations_query);

        if ($donations_result->num_rows > 0) {
            echo '<table border="1">
                    <tr>
                        <th>Donation ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>';

            $total_amount = 0;

            while($donation_row = $donations_result->fetch_assoc()) {
                $total_amount += $donation_row["user_amount"];
                echo '<tr>
                        <td>'.$donation_row["donation_id"].'</td>
                        <td>'.$donation_row["user_amount"].'</td>
                        <td>'.$donation_row["date_date"].'</td>
                    </tr>';
            }

            echo '</table>';

            // Display total amount
            echo '<div class="total-amount">Total Amount: PHP '.$total_amount.'</div>';

            // Print button
            echo '<br>';
            echo '<button onclick="window.print()">PRINT</button>';
        } else {
            echo "No donations found for $user_firstname $user_lastname.";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}

$conn->close();
?>

</body>
</html>
