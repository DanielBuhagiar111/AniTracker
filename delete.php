<?php
session_start();
if (!$_SESSION['account_index']) {
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
    <title>Add</title>
    <link rel="stylesheet" href="color.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.9.0/validator.min.js"></script>
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
                echo "<script>console.log($_SESSION[account_index])</script>";
                include('subheader.php');
                ?>
                <form method="post">
                    <?php
                    $account_id = trim($_SESSION['account_index']);
                    require_once('dbconn.php');
                    $conn = connectToDb();
                    $query_count = "SELECT COUNT(*) AS num_animes FROM tbl_anime WHERE account_id = '$account_id'";
                    $result_count = mysqli_query($conn, $query_count);
                    $row_count = mysqli_fetch_assoc($result_count);
                    $num_animes = $row_count['num_animes'];
                    ?>
                    <ion-text>
                        <h1 style='margin-top:0%;'>Delete Anime by index in view list</h1>
                        Please fill in the input field use the indexes in the view list, for example to delete the first item just input 1.<br>
                        <?php
                        if ($num_animes == 1) {
                            $message = "There is currently " . $num_animes . " anime in your list.";
                        } else {
                            $message = "There are currently " . $num_animes . " anime in your list.";
                        }
                        echo $message;
                        ?>
                    </ion-text>
                    <ion-list>
                        <ion-item>
                            <ion-label position="floating">Index</ion-label>
                            <ion-input name="index" id="index" clear-input="true" data-num-animes="<?php echo $num_animes; ?>"></ion-input>
                        </ion-item>
                    </ion-list>
                    <input type="submit" name="delete" value="Delete" id="submitButton" class="custom-button">
                </form>
                <p id="error" style="color:red;">Input field required!</p>
                <script src="delete.js?v=1"></script>
            </ion-content>
            <?php include('footer.html'); ?>
        </ion-page>
    </ion-app>
</body>

</html>

<?php
if (isset($_POST['delete'])) {
    $index = trim($_POST['index'] - 1);
    $account_id = trim($_SESSION['account_index']);

    require_once('dbconn.php');
    $conn = connectToDb();

    $index = mysqli_real_escape_string($conn, $index);
    $account_id = mysqli_real_escape_string($conn, $account_id);

    $query = "SELECT * FROM tbl_anime WHERE account_id = '$account_id'";
    $result = mysqli_query($conn, $query);

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $anime_id = $rows[$index]['anime_id'];
    $delete_query = "DELETE FROM tbl_anime WHERE anime_id = '$anime_id'";
    mysqli_query($conn, $delete_query) or die("Error in database query");

    mysqli_close($conn);
    echo "<script>window.location.href='view.php';</script>";
}
?>