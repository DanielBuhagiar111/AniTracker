<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
  <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />
  <title>Login</title>
  <link rel="stylesheet" href="color.css">
</head>

<body>
  <ion-app>
    <?php include('header.html'); ?>
    <ion-content class="ion-padding">
      <form method="post">
        <ion-text>
          <h1>Log In</h1>
          Please fill in all the input fields and also note that the password has to have at least 3 characters and a valid email has to be inputted.
        </ion-text>
        <ion-list>
          <ion-item>
            <ion-label position="floating">Mobile Number or Email</ion-label>
            <ion-input name="numberxemail" clear-input="true"></ion-input>
          </ion-item>
          <ion-item>
            <ion-label position="floating">Password</ion-label>
            <ion-input type="password" name="password" clear-input="true"></ion-input>
          </ion-item>
        </ion-list>

        <input type="submit" name="emaillogin" value="Email login" class="custom-button">
        <input type="submit" name="numebrlogin" value="Number login" class="custom-button">
        <input type="submit" name="create" value="Create Account" class="custom-button" style="float:right;">
      </form>
      <?php
      if (isset($_POST['emaillogin'])) {
        $numberxemail = trim($_POST['numberxemail']);
        $password = trim($_POST['password']);
        if (empty($password) || empty($numberxemail)) {
          echo "<p style='color:red;'>Please fill in all input fields!</p>";
        } else {
          if (!filter_var($numberxemail, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color:red;'>Invalid email address!</p>";
          } else if (strlen($password) < 3) {
            echo "<p style='color:red;'>Password has to be 3 or more characters!</p>";
          } else {
            require_once('dbconn.php');
            $conn = connectToDb();

            $numberxemail = mysqli_real_escape_string($conn, $numberxemail);
            $password = mysqli_real_escape_string($conn, $password);

            $query = "SELECT * FROM `tbl_accounts` WHERE `account_email`='$numberxemail'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $hashedPassword = $row['account_password'];

              if (password_verify($password, $hashedPassword)) {
                $account_index = $row['account_id'];
                $_SESSION['account_index'] = $account_index;
                echo "<script>console.log($_SESSION[account_index])</script>";
                mysqli_close($conn);
                echo "<script>window.location.href='view.php';</script>";
              } else {
                mysqli_close($conn);
                echo "<p style='color:red;'>Incorrect inputs!</p>";
              }
            } else {
              mysqli_close($conn);
              echo "<p style='color:red;'>Incorrect inputs!</p>";
            }
          }
        }
      } else if (isset($_POST['numebrlogin'])) {
        $numberxemail = trim($_POST['numberxemail']);
        $password = trim($_POST['password']);
        if (empty($password) || empty($numberxemail)) {
          echo "<p style='color:red;'>Please fill in all input fields!</p>";
        } else {
          if (strlen($password) < 3) {
            echo "<p style='color:red;'>Password has to be 3 or more characters!</p>";
          } else {
            require_once('dbconn.php');
            $conn = connectToDb();

            $numberxemail = mysqli_real_escape_string($conn, $numberxemail);
            $password = mysqli_real_escape_string($conn, $password);

            $query = "SELECT * FROM `tbl_accounts` WHERE `account_number`='$numberxemail'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $hashedPassword = $row['account_password'];

              if (password_verify($password, $hashedPassword)) {
                $account_index = $row['account_id'];
                $_SESSION['account_index'] = $account_index;
                echo "<script>console.log($_SESSION[account_index])</script>";
                mysqli_close($conn);
                echo "<script>window.location.href='view.php';</script>";
              } else {
                mysqli_close($conn);
                echo "<p style='color:red;'>Incorrect inputs!</p>";
              }
            } else {
              mysqli_close($conn);
              echo "<p style='color:red;'>Incorrect inputs!</p>";
            }
          }
        }
      } else if (isset($_POST['create'])) {
        echo "<script>window.location.href='create.php';</script>";
      }

      ?>
    </ion-content>
    <?php include('footer.html'); ?>
  </ion-app>
</body>

</html>