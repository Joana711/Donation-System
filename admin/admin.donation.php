<?php

include_once '../classes/class.user.php';
include '../main/data.php';

$page = $_GET['page'] ?? '';
$subpage = $_GET['subpage'] ?? '';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

$user = new User();
if (!$user->get_session()) {
    header("location: ../main/login.php");
    exit();
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <nav>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admin.donation.php">Donations</a></li>
            <li><a href="admin.users.php">Users</a></li>
            <li><a href="../main/logout.php" class="right">Log out</a></li>
            <li><a href="" class="donate-button"><?php echo $user->get_user_lastname($user_id) . ', ' . $user->get_user_firstname($user_id); ?></a></li>
        </ul>
    </nav>

    <div class="hero-image">
    </div>

    <div class="content" style="display: flex;">

        <div style="flex: 1.5;">
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

            $amountFilter = "user_amount > 0";

            $query = "SELECT users.user_id, users.user_firstname, users.user_lastname, users.user_email, donations.user_amount, donations.date_date
            FROM users
            JOIN donations ON users.user_id = donations.user_id
            WHERE $amountFilter
            ORDER BY users.user_id ASC";

            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                echo '<table border="1">
                    <tr>
                        <th>ID              </th>
                        <th>First Name      </th>
                        <th>Last Name       </th>
                        <th>Email address   </th>
                        <th>Amount          </th>
                        <th>Date            </th>
                    </tr>';

                $totalAmount = 0; // Initialize total amount variable

                while ($row = $result->fetch_assoc()) {
                    $totalAmount += $row["user_amount"]; // Add to total amount
                    echo '<tr>
                        <td>' . $row["user_id"] . '</td>
                        <td>' . $row["user_firstname"] . '</td>
                        <td>' . $row["user_lastname"] . '</td>
                        <td>' . $row["user_email"] . '</td>
                        <td>' . $row["user_amount"] . '</td>
                        <td>' . $row["date_date"] . '</td>
                    </tr>';
                }

                echo '<tr>
                    <td colspan="4"><strong>Total Amount</strong></td>
                    <td colspan="2"><strong>' . number_format($totalAmount, 2) . '</strong></td>
                </tr>';
                echo '</table>';
                echo '</br>';
                echo '</br>';
                
            } else {
                // You can handle the "no results" case here, if needed
                echo "No results found.";
            }
            ?>
        </div>

        <div style="flex: 1;">
            <?php
            // Collect data for the chart
            $chartData = [];
            $chartLabels = [];

            $yearlyTotal = [];

            $result->data_seek(0); // Reset result pointer to fetch data again

            while ($row = $result->fetch_assoc()) {
                $year = date('Y', strtotime($row["date_date"]));
                $amount = $row["user_amount"];

                if (!isset($yearlyTotal[$year])) {
                    $yearlyTotal[$year] = 0;
                }

                $yearlyTotal[$year] += $amount;
            }

            // Prepare chart data from the yearly totals
            foreach ($yearlyTotal as $year => $total) {
                $chartLabels[] = $year;
                $chartData[] = $total;
            }
            ?>

            <div class="chart-container" style="width: 400px; height: 400px; margin-left: 50px; margin-top: 30px;padding: 10px; position: sticky;">
                <canvas id="donationChart"></canvas>
            </div>

            <script>
                var ctx = document.getElementById('donationChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($chartLabels); ?>,
                        datasets: [{
                            label: 'Donation Amount',
                            data: <?php echo json_encode($chartData); ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            position: 'right',
                            labels: {
                                fontColor: 'black'
                            }
                        }
                    }
                });
            </script>
        </div>

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
