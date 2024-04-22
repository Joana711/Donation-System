<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "group12";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO donations (user_id, user_amount, date_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("id", $user_id, $amount);

    $email = $_POST['useremail'];
    $userQuery = "SELECT user_id FROM users WHERE user_email = ?";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->bind_param("s", $email);
    $userStmt->execute();
    $result = $userStmt->get_result();
    if ($result->num_rows > 0) {
        // User exists, get the user_id
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Set parameter for donation
        $amount = $_POST['amount'];

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to success page or do something else
        header("location: ../donator/donator.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
}
?>