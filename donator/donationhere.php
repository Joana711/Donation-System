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
        <h1>Let's begin!</h1>
        <p>We're here to guide you every step of the way.</p>
        <img src="../css/bye.jpg">
    </div>
    
    <div class="log">

        <form method="POST" action="../process/donator.process.php" name="register">
            <p>Personal Details
            </p>
            <div>
                <input type="text" style="width: 48%;" class="input" required name="userfirstname" placeholder="First name"/>
            </div>
            <div>
                <input type="text" style="width: 48%; float: right; margin-top: -72px;" class="input" required name="userlastname" placeholder="Last name"/>
            </div>
            <div>
                <input type="email" style="width: 48%;" class="input" required name="useremail" placeholder="Email address"/>
            </div>
            
            <div>
                <select id="access" name="access" style="width: 48%; float: right; margin-top: -72px;">
                    <option value="donator">Donator</option>
                </select>
            </div>
            <p>Billing Address</p>
            <div>
                <input type="text" class="input" required name="address" placeholder="Your Address"/>
            </div>
            <p>Please insert your amount</p>
            <div>
                <input type="text" class="input" required name="amount" placeholder="Enter amount"/>
            </div>
            
            <br><br>
            <div>
                <center><input type="submit" style="margin-top: -20px;"name="submit" value="Submit"/></center>
            </div>
        </form>
    </div>
</body>