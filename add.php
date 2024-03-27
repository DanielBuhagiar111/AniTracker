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
                    <ion-text>
                        <h1 style='margin-top:0%;'>Add Anime</h1>
                        Please fill in all the input fields.
                    </ion-text>
                    <ion-list>
                        <ion-item>
                            <ion-label position="floating">Title</ion-label>
                            <ion-input name="title" id="title" clear-input="true"></ion-input>
                        </ion-item>
                        <ion-item>
                            <ion-label position="floating">Studio</ion-label>
                            <ion-input name="studio" id="studio" clear-input="true"></ion-input>
                        </ion-item>
                        <ion-item>
                            <ion-label position="floating">Score out of 10</ion-label>
                            <ion-input name="score" id="score" clear-input="true"></ion-input>
                        </ion-item>
                        <ion-item>
                            <ion-label position="floating">Episodes watched</ion-label>
                            <ion-input name="watched_eps" id="watched_eps" clear-input="true"></ion-input>
                        </ion-item>
                        <ion-item>
                            <ion-label position="floating">Total number of episodes or ? if not known</ion-label>
                            <ion-input name="total_eps" id="total_eps" clear-input="true"></ion-input>
                        </ion-item>
                    </ion-list>
                    <input type="submit" name="add" value="Add" id="submitButton" class="custom-button">
                </form>
                <p id="error" style="color:red;">All input fields are required!</p>
                <script src="add_edit.js"></script>
            </ion-content>
            <?php include('footer.html'); ?>
        </ion-page>
    </ion-app>
</body>

</html>

<?php
if (isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $studio = trim($_POST['studio']);
    $score = trim($_POST['score']);
    $watched_eps = trim($_POST['watched_eps']);
    $total_eps = trim($_POST['total_eps']);
    $account_id = trim($_SESSION['account_index']);

    require_once('dbconn.php');
    $conn = connectToDb();

    $title = mysqli_real_escape_string($conn, $title);
    $studio = mysqli_real_escape_string($conn, $studio);
    $score = mysqli_real_escape_string($conn, $score);
    $watched_eps = mysqli_real_escape_string($conn, $watched_eps);
    $total_eps = mysqli_real_escape_string($conn, $total_eps);
    $account_id = mysqli_real_escape_string($conn, $account_id);

    if ($total_eps == '?') {
        $total_eps = -1;
    }

    $sql = "INSERT INTO `tbl_anime` (`anime_id`, `anime_title`, `anime_studio`, `anime_score`, `anime_watched_eps`, `anime_total_eps`, `account_id`) VALUES (NULL, '$title', '$studio', '$score', '$watched_eps', '$total_eps','$account_id');";

    mysqli_query($conn, $sql)
        or die("Error in database query");

    mysqli_close($conn);
    echo "<script>window.location.href='view.php';</script>";
}
?>