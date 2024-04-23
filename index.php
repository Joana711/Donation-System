<?php
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
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="popup-wrapper" id="popupWrapper">
    <center>
    <div class="popup" id="popup">
        <h2>Choose your User!</h2>
        <a href="main/login.php">Admin</a>
        <a href="donator/donator.login.php">Donator</a>
    </div>
    </center>
  </div>

  <nav>
    <ul>
      <li><a href="#"><ion-icon name="search" aria-label="search"></ion-icon></a></li>
      <li><input type="search" placeholder="Search"></li>
      <li><a href="index.php">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="" id="popupLink" class="right">Log In</a></li>
      <li><a href="" onclick="myFunction()" class="donate-button">DONATE HERE</a></li>
    </ul>
  </nav>

  <div class="hero-image">
    <div class="hero-text">
      <h1 style="font-size:60px">Charity Flow</h1>
      <b>
        <p>“Flowing Generosity, Changing Lives”</p>
      </b>
      <button onclick="myFunction()"> DONATE HERE </button>
    </div>
  </div>

  <div class="content">

    <br><br>
    <h1>Why Charity Flow?</h1>

    <div class="why">
      <div class="box">
        <center><ion-icon name="accessibility"></ion-icon></center>
        <h3>Simple to Use</h3>
        <p>We pride ourselves on making things easy to use.</p>
      </div>
      <div class="box">
        <center><ion-icon name="people-circle"></ion-icon></center>
        <h3>Donors</h3>
        <p>People like you give to your favorite donations; you feel great when you get updates about how your money
          will put to wprk by trusted people.</p>
      </div>
      <div class="box">
        <center><ion-icon name="pricetags"></ion-icon></center>
        <h3>Affordable, Scalable Pricing</h3>
        <p>Our pricing model scales with your donation volume and ensures no hidden fees or surprises.</p>
      </div>
      <div class="box">
        <center><ion-icon name="shield-checkmark"></ion-icon></center>
        <h3>Safe and Secure</h3>
        <p>Data privacy compliance with encryption and protection against cyber attacks.</p>
      </div>
    </div>

    <br><br><br><br><br>
  </div>

  <div class="page">
    <br>
    <h1>We've got you covered.</h1>
    <h1>Charity Flow is a trusted online donation site for Sipalay City, Brgy. 1. With <u>simple pricing</u> and a team
      of <u>Trust & Safety</u> experts in your corner, you can raise money or make a donation with peace of mind.</h1>
    <img src="css/bye.jpg">
    <br><br><br>
  </div>

  <div class="fund">
    <h1>Fundraise for anyone</h1>
  </div>

  <h1>Friends and Family</h1>
  <p>You’ll invite a beneficiary to receive funds or distribute them yourself</p>
  <br>
  <hr><br>
  <h1>Charity</h1>
  <p>Funds are delivered to your chosen nonprofit for you</p>
  <br><hr>

</body>

<footer>
  <div class="footer-content">
    <div class="footer-section">
      <h3>About Us</h3>
      <p>Charity Flow is dedicated to facilitating a continuous stream of generosity, 
        where every contribution creates a ripple effect of positive change in the lives of those in need.</p>
      <div class="social-icons">
        <a href="https://www.facebook.com/groups/353244247737258"><ion-icon name="logo-facebook"></ion-icon></a>
        <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
        <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
        <a href="#"><ion-icon name="logo-youtube"></ion-icon></a>
      </div>
    </div>
    <div class="footer-section">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h3>Subscribe to Our Newsletter</h3>
      <form class="subscribe-form" action="#" method="post">
        <input type="email" name="email" placeholder="Your Email">
        <input type="submit" value="Subscribe">
      </form>
    </div>
  </div>
  <div class="footer-bottom">
    &copy; <span id="currentYear"></span> Your Company Name. All rights reserved.
  </div>
</footer>

<script>document.getElementById('currentYear').textContent = new Date().getFullYear();</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script>
    function showPopup() {
        var popupWrapper = document.getElementById("popupWrapper");
        popupWrapper.style.display = "block";
    }

    document.getElementById("popupLink").addEventListener("click", function(event) {
        event.preventDefault(); 
        showPopup();
    });
</script>

<script>
  function myFunction() {
    alert("Please Log In first");
  }
</script>

</html>