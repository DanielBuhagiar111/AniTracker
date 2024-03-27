<?php
require_once('dbconn.php');
$conn = connectToDb();
$query = "SELECT * FROM tbl_accounts WHERE account_id=$_SESSION[account_index]";
$result2 = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result2)) {
    echo "
            <ion-grid>
              <ion-row>
                <ion-col size='9' class='ion-align-self-center'>
                  <ion-menu-toggle>
                    <ion-button style='width: 10%;' color='green'>
                      <ion-icon name='menu-outline'></ion-icon>
                    </ion-button>
                  </ion-menu-toggle>
                </ion-col>
                <ion-col size='2' class='ion-text-right ion-align-self-center'>
                  {$row['account_name']} {$row['account_surname']} 
                </ion-col>     
                <ion-col size='1' class='ion-text-right ion-align-self-center'>
                  <img src='{$row['account_picture']}' alt='Profile picture' style='width:80%; border:3px solid #2be954;'>
                </ion-col>                
              </ion-row>
            </ion-grid>
          ";
}
?>