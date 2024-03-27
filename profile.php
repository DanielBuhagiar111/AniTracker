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
    <title>Profile</title>
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
                <?php
                require_once('dbconn.php');
                $conn = connectToDb();
                $index = mysqli_real_escape_string($conn, trim($_SESSION['account_index']));
                $query = "SELECT * FROM tbl_accounts WHERE account_id ='$index'";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <form enctype='multipart/form-data' method='post'>
                        <ion-text>
                            <h1>Edit Account</h1>
                            Please fill in all the input fields and if you wish change the profile picture and also note that the password has to have at least 3 characters, a valid email should be entered and the name and surname have to be less than 16 characters long. If you wish to delete your account fill in your password and press delete.
                        </ion-text>
                        <ion-list>
                            <ion-item>
                                <ion-label position='floating'>Current Password</ion-label>
                                <ion-input type='password' name='currentpassword' id='currentpassword' clear-input='true'></ion-input>
                            </ion-item>
                            <ion-item>
                                <ion-label position='floating'>Name</ion-label>
                                <ion-input name='name' id='name' clear-input='true' value='$row[account_name]'></ion-input>
                            </ion-item>
                            <ion-item>
                                <ion-label position='floating'>Surname</ion-label>
                                <ion-input name='surname' id='surname' clear-input='true' value='$row[account_surname]'></ion-input>
                            </ion-item>
                            <ion-item>
                                <ion-label position='floating'>Email</ion-label>
                                <ion-input name='email' id='email' clear-input='true' value='$row[account_email]'></ion-input>
                            </ion-item>
                            <ion-item>
                                <ion-label position='floating'>Password</ion-label>
                                <ion-input type='password' id='password' name='password' clear-input='true' value='$row[account_password]'></ion-input>
                            </ion-item>
                            <ion-item>
                                <ion-label position='floating'>Mobile number</ion-label>
                                <ion-input name='number' id='number' clear-input='true' value='$row[account_number]'></ion-input>
                            </ion-item>
                            <ion-item>
                                <input type='hidden' name='MAX_FILE_SIZE' value='1000000'>
                                <input type='file' name='profilepic'>
                            </ion-item>
                        </ion-list>
                        <input type='submit' id='editButton' name='editButton' value='Change Account details' class='custom-button'>
                        <input type='submit' id='deleteButton' name='deleteButton' value='Delete Account' class='custom-button' style='float:right;'>
                    </form>
                    ";
                }
                ?>
                <p id="error" style="color:red;">All input fields are required except the choose file input!</p>
                <p id="submit_error" style="color:red;"></p>
                <script src="profile.js"></script>
                <?php
                if (isset($_POST['editButton'])) {
                    $currentpassword = trim($_POST['currentpassword']);
                    $name = trim($_POST['name']);
                    $surname = trim($_POST['surname']);
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    $number = trim($_POST['number']);
                    $profilepic = $_FILES['profilepic']['tmp_name'];
                    $account_id = trim($_SESSION['account_index']);
                    require_once('dbconn.php');
                    $conn = connectToDb();
                    $currentpassword = mysqli_real_escape_string($conn, $currentpassword);
                    $name = mysqli_real_escape_string($conn, $name);
                    $surname = mysqli_real_escape_string($conn, $surname);
                    $email = mysqli_real_escape_string($conn, $email);
                    $password = mysqli_real_escape_string($conn, $password);
                    $number = mysqli_real_escape_string($conn, $number);
                    $query = "SELECT * FROM tbl_accounts WHERE account_id='$account_id'";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $storedPassword = $row['account_password'];
                        if ($password != $storedPassword) {
                            $password = password_hash($password, PASSWORD_DEFAULT);
                        }
                        if (password_verify($currentpassword, $storedPassword)) {
                            if (empty($profilepic)) {
                                $query = "UPDATE tbl_accounts SET `account_name`='$name', `account_surname`='$surname', `account_email`='$email', `account_password`='$password', `account_number`='$number', `account_picture`='$row[account_picture]' WHERE account_id='$account_id'";
                                mysqli_query($conn, $query) or die("Error in database query");
                            } else {
                                $originalFileName = $_FILES['profilepic']['name'];
                                $fileHash = md5_file($profilepic);
                                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                                $baseName = pathinfo($originalFileName, PATHINFO_FILENAME);
                                $newFileName = $baseName;
                                $counter = 1;
                                $existingFilePath = '';
                                $files = glob("images/*.$extension");
                                foreach ($files as $file) {
                                    if (md5_file($file) === $fileHash) {
                                        $existingFilePath = $file;
                                        break;
                                    }
                                }
                                if (!empty($existingFilePath)) {
                                    $newFilePath = $existingFilePath;
                                } else {
                                    while (file_exists("images/$newFileName.$extension")) {
                                        $newFileName = $baseName . '_' . $counter;
                                        $counter++;
                                    }
                                    $newFilePath = "images/$newFileName.$extension";
                                    move_uploaded_file($profilepic, $newFilePath);
                                }
                                $query = "UPDATE tbl_accounts SET `account_name`='$name', `account_surname`='$surname', `account_email`='$email', `account_password`='$password', `account_number`='$number', `account_picture`='$newFilePath' WHERE account_id='$account_id'";
                                mysqli_query($conn, $query) or die("Error in database query");
                                $query = "SELECT account_picture FROM tbl_accounts";
                                $result = mysqli_query($conn, $query);
                                if ($result) {
                                    $usedFilePaths = [];
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $usedFilePaths[] = $row['account_picture'];
                                    }
                                    $imageFolder = "images/";
                                    $files = glob($imageFolder . "*");
                                    foreach ($files as $file) {
                                        $filePath = $imageFolder . basename($file);
                                        if (!in_array($filePath, $usedFilePaths)) {
                                            unlink($file);
                                        }
                                    }
                                }
                                mysqli_close($conn);
                                echo "<script>window.location.href='view.php';</script>";
                            }
                            mysqli_close($conn);
                            echo "<script>window.location.href='view.php';</script>";
                        } else {
                            echo "<script>document.getElementById('error').innerHTML='Incorrect password entered!'</script>";
                            mysqli_close($conn);
                        }
                    }
                } else if (isset($_POST['deleteButton'])) {
                    $currentpassword = trim($_POST['currentpassword']);
                    $account_id = trim($_SESSION['account_index']);
                    require_once('dbconn.php');
                    $conn = connectToDb();
                    $currentpassword = mysqli_real_escape_string($conn, $currentpassword);
                    $query = "SELECT * FROM tbl_accounts WHERE account_id='$account_id'";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $storedPassword = $row['account_password'];
                    }
                    if (password_verify($currentpassword, $storedPassword)) {
                        $query = "DELETE FROM tbl_anime WHERE account_id='$account_id'";
                        mysqli_query($conn, $query) or die("Error in database query");
                        $query = "DELETE FROM tbl_accounts WHERE account_id='$account_id'";
                        mysqli_query($conn, $query) or die("Error in database query");
                        $query = "SELECT account_picture FROM tbl_accounts";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $usedFilePaths = [];
                            while ($row = mysqli_fetch_assoc($result)) {
                                $usedFilePaths[] = $row['account_picture'];
                            }
                            $imageFolder = "images/";
                            $files = glob($imageFolder . "*");
                            foreach ($files as $file) {
                                $filePath = $imageFolder . basename($file);
                                if (!in_array($filePath, $usedFilePaths)) {
                                    unlink($file);
                                }
                            }
                        }
                        mysqli_close($conn);
                        echo "<script>window.location.href='index.php';</script>";
                    } else {
                        echo "<script>document.getElementById('error').innerHTML='Incorrect password entered!'</script>";
                        mysqli_close($conn);
                    }
                }
                ?>
            </ion-content>
            <?php include('footer.html'); ?>
        </ion-page>
    </ion-app>
</body>

</html>