<?php
  include_once 'data.php';
  include_once '../classes/class.user.php';

  $user = new User();
  if($user->get_session()){
    header("location: ../admin/admin.php");
  }
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">

  <style>
    #error_notif {
      background-color: #436850;
      color: white;
      padding: 10px; 
      margin-top: -130px; 
      text-align: center; 
    }
  </style>

</head>

<body>
    <div class="intro">
        <h3>WELCOME, ADMIN!</h3>
        <h1>Charity Flow</h1>
        <p>Flowing Generosity, Changing Lives</p>
        <img src="../css/bye.jpg">
    </div>
    
    <div class="log">
        <p style="float:right; margin-top:50px; margin-right:50px">
            Don't have an account? 
            <a href="register.php"><button>Sign up</button></a>
        </p>
        <form method="POST" action="" name="login">
            <p>Your account details</p>
            <div>
                <input type="email" class="input" required name="useremail" placeholder="Email address"/>
            </div>
            <div>
                <input type="password" class="input" required name="password" placeholder="Password"/>
            </div>
            <a href="#"></a><button>Forgot your password?</button><a>
            <br><br><br><br><br><br>
            <div>
                <center><input type="submit" name="submit" value="Submit"/></center>
            </div>
        </form>

        <?php
        include_once 'data.php';
        include_once '../classes/class.user.php';

        $user = new User();

        if(isset($_REQUEST['submit'])){
        extract($_REQUEST);
        $login = $user->check_login($useremail,$password);
        if(!$login){
            ?>
            <div id='error_notif'>Wrong email or password.</div>
            <?php
        }
        
        else if($user->get_session()){
            header("location: ../admin/admin.php");
        }
        }
        ?>

    </div>
</body>

</html>