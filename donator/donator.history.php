<?php
include_once "../classes/class.user.donator.php";
include '../main/data.php';

$page = $_GET['page'] ?? '';
$subpage = $_GET['subpage'] ?? '';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

$user = new User();

if (!$user->get_session()) {
    header("location: ../main/login.php");
    exit;
}

if (!isset($_SESSION['user_email'])) {
    header("location: ../main/login.php");
    exit;
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
    <link rel="stylesheet" href="../css/last.css">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .content, .content * {
                visibility: visible;
            }
            .content {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>

<body>
    <div class="popup-wrapper" id="popupWrapper">
        <center>
            <div class="popup" id="popup">
                <h2>Proceed to Logout?</h2>
                <a href="donator.logout.php">Yes</a>
            </div>
        </center>
    </div>

    <nav>
        <ul>
            <li><a href="#"><ion-icon name="search" aria-label="search"></ion-icon></a></li>
            <li><input type="search" placeholder="Search"></li>
            <li><a href="donator.php">Home</a></li>
            <li><a href="donator.history.php">History</a></li>
            <li><a href="" id="popupLink" class="me"><?php echo $user->get_user_lastname($user_id) . ', ' . $user->get_user_firstname($user_id); ?></a></li>
            <li><a href="donationhere.php" class="donate-button">DONATE HERE</a></li>
        </ul>
    </nav>

    <div class="hero-image">
    </div>

    <div class="content">
        <div class="design">
        <form method="GET" action="">
            <label for="timeframe">&nbsp;&nbsp;&nbsp;Select Time Frame:</label>
            <select name="timeframe" id="timeframe" onchange="this.form.submit()">
                <option value="daily" <?php if (isset($_GET['timeframe']) && $_GET['timeframe'] == 'daily') echo 'selected'; ?>>Daily</option>
                <option value="weekly" <?php if (isset($_GET['timeframe']) && $_GET['timeframe'] == 'weekly') echo 'selected'; ?>>Weekly</option>
                <option value="monthly" <?php if (isset($_GET['timeframe']) && $_GET['timeframe'] == 'monthly') echo 'selected'; ?>>Monthly</option>
                <option value="yearly" <?php if (isset($_GET['timeframe']) && $_GET['timeframe'] == 'yearly') echo 'selected'; ?>>Yearly</option>
            </select>
            <ion-icon name="print" id="printIcon" onclick="printTable()"></ion-icon>
        </form>

        <?php
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

        $timeframe = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'daily';
        switch ($timeframe) {
            case 'weekly':
                $dateFilter = "date_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW()";

                $weeklyDonationsQuery = "SELECT YEAR(date_date) AS donation_year, WEEK(date_date) AS donation_week, SUM(user_amount) AS total_amount, 
                                            users.user_id, users.user_firstname, users.user_lastname, users.user_email, MAX(donations.date_date) AS donation_date
                                        FROM donations
                                        JOIN users ON donations.user_id = users.user_id
                                        WHERE users.user_id = ?
                                        GROUP BY donation_year, donation_week, users.user_id
                                        ORDER BY donation_year DESC, donation_week DESC";

                $stmt = $conn->prepare($weeklyDonationsQuery);
                if (!$stmt) {
                    die("Error: " . $conn->error);
                }

                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                echo '<center><h2>Weekly Donations</h2></center>';

                if ($result->num_rows > 0) {
                    $currentWeek = null;
                    $currentYear = null;

                    while ($row = $result->fetch_assoc()) {
                        $year = $row['donation_year'];
                        $week = $row['donation_week'];
                        $userID = $row['user_id'];
                        $firstName = $row['user_firstname'];
                        $lastName = $row['user_lastname'];
                        $email = $row['user_email'];
                        $totalAmount = $row['total_amount'];
                        $donationDate = $row['donation_date'];

                        if ($currentWeek !== $week || $currentYear !== $year) {
                            
                            if ($currentWeek !== null) {
                                echo '</table>';
                            }
                            $currentWeek = $week;
                            $currentYear = $year;
                            
                            echo '<table border="1" >';
                            echo "<tr><td colspan='6' style='background-color:#185C47; color: #f2f2f2;'><strong>Week $week, $year</strong></td></tr>";
                            echo    '<tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email address</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>';
                        }

                        echo "<tr>
                                <td>$userID</td>
                                <td>$firstName</td>
                                <td>$lastName</td>
                                <td>$email</td>
                                <td>PHP " . number_format($totalAmount, 2) . "</td>
                                <td>$donationDate</td>
                              </tr>";

                        echo '<tr><td colspan="4"><strong>Total Amount for this Week</strong></td><td colspan="2"><strong>PHP ' . number_format($totalAmount, 2) . '</strong></td></tr>';
                    }

                    echo '</table>';
                } else {
                    echo "No weekly donation data available.";
                }
                break;

            case 'monthly':
                $dateFilter = "date_date BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW()";

                $monthlyDonationsQuery = "SELECT YEAR(date_date) AS donation_year, MONTH(date_date) AS donation_month, SUM(user_amount) AS total_amount, 
                                            users.user_id, users.user_firstname, users.user_lastname, users.user_email, MAX(donations.date_date) AS donation_date
                                        FROM donations
                                        JOIN users ON donations.user_id = users.user_id
                                        WHERE users.user_id = ?
                                        GROUP BY donation_year, donation_month, users.user_id
                                        ORDER BY donation_year DESC, donation_month DESC";

                $stmt = $conn->prepare($monthlyDonationsQuery);
                if (!$stmt) {
                    die("Error: " . $conn->error);
                }

                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $currentYear = 0;
                    echo '<center><h2>Monthly Donations</h2></center>';

                    while ($row = $result->fetch_assoc()) {
                        $year = $row['donation_year'];
                        $userID = $row['user_id'];
                        $firstName = $row['user_firstname'];
                        $lastName = $row['user_lastname'];
                        $email = $row['user_email'];
                        $month = date("F", mktime(0, 0, 0, $row['donation_month'], 10));
                        $totalAmount = $row['total_amount'];
                        $donationDate = $row['donation_date'];

                        if ($currentYear != $year) {
                            if ($currentYear != 0) {
                                echo '<tr><td colspan="5"><strong>Total Amount for Year ' . $currentYear . ':</strong></td><td colspan="2"><strong>PHP ' . number_format($yearTotalAmount, 2) . '</strong></td></tr>';
                                echo '</table>';
                            }
                            
                            echo '<table border="1">';
                            echo "<tr><td colspan='7' style='background-color:#185C47; color: #f2f2f2;'><strong>Year $year</strong></td></tr>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email address</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>";
                            $currentYear = $year;
                            $yearTotalAmount = 0;
                        }

                        $yearTotalAmount += $totalAmount;

                        echo "<tr>
                                <td>$userID</td>
                                <td>$firstName</td>
                                <td>$lastName</td>
                                <td>$email</td>
                                <td>$month</td>
                                <td>PHP " . number_format($totalAmount, 2) . "</td>
                                <td>$donationDate</td>
                              </tr>";
                    }

                    echo '<tr><td colspan="5"><strong>Total Amount for Year ' . $currentYear . ':</strong></td><td colspan="2"><strong>PHP ' . number_format($yearTotalAmount, 2) . '</strong></td></tr>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo "No monthly donation data available.";
                }
                break;

                case 'yearly':
                    $dateFilter = "date_date BETWEEN DATE_SUB(NOW(), INTERVAL 5 YEAR) AND NOW()";
    
                    $yearQuery = "SELECT DISTINCT YEAR(date_date) AS donation_year FROM donations";
                    $yearResult = $conn->query($yearQuery);

                    echo '<center><h2>Yearly Donations</h2></center>';
    
                    if ($yearResult->num_rows > 0) {
                        while ($yearRow = $yearResult->fetch_assoc()) {
                            $donationYear = $yearRow['donation_year'];
    
                            $donationQuery = "SELECT donations.donation_id, users.user_firstname, users.user_lastname, users.user_email, donations.user_amount, donations.date_date
                                FROM users
                                JOIN donations ON users.user_id = donations.user_id
                                WHERE YEAR(donations.date_date) = $donationYear
                                AND users.user_id = '$user_id'";
    
                            $donationResult = $conn->query($donationQuery);
    
                            if ($donationResult->num_rows > 0) {
                                $yearTotalAmount = 0;
                                echo '<table border="1">';
                                echo "<tr><td colspan='6' style='background-color:#185C47; color: #f2f2f2;'><strong>Year $donationYear</strong></td></tr>";
                                echo    '<tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email address</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>';
    
                                while ($row = $donationResult->fetch_assoc()) {
                                    $yearTotalAmount += $row["user_amount"];
    
                                    echo '<tr>
                                            <td>' . $row["donation_id"] . '</td>
                                            <td>' . $row["user_firstname"] . '</td>
                                            <td>' . $row["user_lastname"] . '</td>
                                            <td>' . $row["user_email"] . '</td>
                                            <td>PHP ' . $row["user_amount"] . '</td>
                                            <td>' . $row["date_date"] . '</td>
                                        </tr>';
                                }
    
                                echo '<tr><td colspan="4"><strong>Total Amount for Year ' . $donationYear . ':</strong></td><td colspan="2"><strong>PHP ' . number_format($yearTotalAmount, 2) . '</strong></td></tr>';
                                echo '</table>';
                            } else {
                                echo 'No results found for year: ' . $donationYear;
                            }
                        }
                    } else {
                        echo 'No donation data available.';
                    }
                break;

                default:
                $userHistoryFilter = "users.user_id = '$user_id'";
                $totalDonationAmount = 0;
            
                $today = date("Y-m-d");
                $recentDonationsQuery = "SELECT donations.donation_id, users.user_firstname, users.user_lastname, users.user_email, donations.user_amount, donations.date_date
                    FROM users
                    JOIN donations ON users.user_id = donations.user_id
                    WHERE DATE(donations.date_date) = '$today' AND " . $userHistoryFilter;

                $recentResult = $conn->query($recentDonationsQuery);

                if ($recentResult->num_rows > 0) {
                    echo '<center><h3>Recent Donations Today</h3><center>';
                    echo '<table border="1">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email address</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>';

                    while ($row = $recentResult->fetch_assoc()) {
                        $totalDonationAmount += $row["user_amount"];

                        echo '<tr>
                                <td>' . $row["donation_id"] . '</td>
                                <td>' . $row["user_firstname"] . '</td>
                                <td>' . $row["user_lastname"] . '</td>
                                <td>' . $row["user_email"] . '</td>
                                <td>PHP '. $row["user_amount"] . '</td>
                                <td>' . $row["date_date"] . '</td>
                            </tr>';
                    }

                    // Display total amount for today
                    echo '<tr><td colspan="4"><strong>Total Amount for Today</strong></td><td colspan="2"><strong>PHP ' . number_format($totalDonationAmount, 2) . '</strong></td></tr>';
                    echo '</table>';
                } else {
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No recent donations today.';
                }
        
            
                $amountFilter = "donations.user_amount > 0";
                $whereClause = implode(" AND ", array_filter([$userHistoryFilter]));
            
                $query = "SELECT donations.donation_id, users.user_firstname, users.user_lastname, users.user_email, donations.user_amount, donations.date_date
                    FROM users
                    JOIN donations ON users.user_id = donations.user_id";
            
                if (!empty($whereClause)) {
                    $query .= " WHERE $whereClause";
                }
            
                $result = $conn->query($query);
            
                $totalDonationAmount = 0;

                echo '<center><h3> Donations </h3><center>';
            
                if ($result->num_rows > 0) {
                    echo '<table border="1">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email address</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>';
            
                    while ($row = $result->fetch_assoc()) {
                        $totalDonationAmount += $row["user_amount"];
            
                        echo '<tr>
                                <td>' . $row["donation_id"] . '</td>
                                <td>' . $row["user_firstname"] . '</td>
                                <td>' . $row["user_lastname"] . '</td>
                                <td>' . $row["user_email"] . '</td>
                                <td>PHP '. $row["user_amount"] . '</td>
                                <td>' . $row["date_date"] . '</td>
                            </tr>';
                    }
            
                    echo '<tr><td colspan="4"><strong>Total Amount</strong></td><td colspan="2"><strong>PHP ' . number_format($totalDonationAmount, 2) . '</strong></td></tr>';
                    echo '</table>';
                } else {
                    echo 'No results found.';
                }
                break;
            }
        ?>

        <br><br><br><br><br>
        </div>
    </div>

    <script>document.getElementById('currentYear').textContent = new Date().getFullYear();</script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        // Function to show the popup
        function showPopup() {
            var popupWrapper = document.getElementById("popupWrapper");
            popupWrapper.style.display = "block";
        }
        // Attach event listener to the hyperlink to show the popup
        document.getElementById("popupLink").addEventListener("click", function(event) {
            event.preventDefault();
            showPopup();
        });

        function printTable() {
        window.print();
        }
    </script>

</body>

</html>
