<?php
session_start();
if(!$_SESSION['account_index']){
  echo "<script>window.location.href='index.php';</script>";
}
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
  <title>View</title>
  <link rel="stylesheet" href="color.css">
  <script src="signout.js"></script>
</head>

<body>
  <ion-app>
    <ion-menu content-id="main-content">
      <ion-header>
        <ion-toolbar color="green">
          <ion-title>Menu</ion-title>
        </ion-toolbar>
      </ion-header>
      <ion-content>
        <ion-list>
          <ion-list-header> Navigate </ion-list-header>
          <ion-menu-toggle auto-hide="false">
            <ion-item href="view.php" button>
              <ion-icon slot="start" name="eye-outline"></ion-icon>
              <ion-label> View </ion-label>
            </ion-item>
            <ion-item href="add.php" button>
              <ion-icon slot="start" name="add-circle-outline"></ion-icon>
              <ion-label> Add </ion-label>
            </ion-item>
            <ion-item href="delete.php" button>
              <ion-icon slot="start" name="trash-outline"></ion-icon>
              <ion-label> Delete </ion-label>
            </ion-item>
            <ion-item href="profile.php" button>
              <ion-icon slot="start" name="person-circle-outline"></ion-icon>
              <ion-label> Profile </ion-label>
            </ion-item>
            <ion-item href="dbconn.php?action=logout" button>
              <ion-icon slot="start" name="log-out-outline"></ion-icon>
              <ion-label>Log out</ion-label>
            </ion-item>
          </ion-menu-toggle>
        </ion-list>
      </ion-content>
    </ion-menu>
    <ion-page class="ion-page" id="main-content">
      <?php include('header.html'); ?>
      <ion-content class="ion-padding">
        <?php
        require_once('dbconn.php');
        $conn = connectToDb();
        echo "<script>console.log($_SESSION[account_index])</script>";
        include('subheader.php');
        $query = "SELECT * FROM tbl_anime WHERE account_id=$_SESSION[account_index]";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 0) {
          echo "<h2>No anime added yet!</h2>";
        } else {
          $count=1;
          while ($row = mysqli_fetch_assoc($result)) {
            $total_eps = 0;
            if ($row['anime_total_eps'] == -1) {
              $total_eps = '?';
            } else {
              $total_eps = $row['anime_total_eps'];
            }
            echo "
            <ion-card>
              <ion-grid>
                <ion-row>
                  <ion-col size='0.5' class='ion-text-center' style='display: flex; align-items: center; justify-content: center;'>
                    <b><h3>$count</h3></b>
                  </ion-col>
                  <ion-col size='11'>
                    <ion-card-header>
                      <ion-card-title>Title: {$row['anime_title']}</ion-card-title>
                      <ion-card-subtitle>Studio: {$row['anime_studio']}</ion-card-subtitle>
                    </ion-card-header>
                    <ion-card-content>
                      Score: {$row['anime_score']}<br>
                      Episodes: {$row['anime_watched_eps']}/$total_eps
                    </ion-card-content>
                  </ion-col>
                  <ion-col size='0.5' class='ion-text-right'>
                  <ion-button color='green' href='edit.php?cardId={$row['anime_id']}' style='width:100%; height:100%;'>
                    <ion-icon name='pencil-outline'></ion-icon>
                  </ion-button>
                </ion-col>                
                </ion-row>
              </ion-grid>
            </ion-card>   
          ";
          $count++;
          }
        }
        mysqli_close($conn);
        ?>
      </ion-content>
      <?php include('footer.html'); ?>
    </ion-page>
  </ion-app>
</body>

</html>