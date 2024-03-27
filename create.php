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
    <title>Create Account</title>
    <link rel="stylesheet" href="color.css">
</head>

<body>
    <ion-app>
        <?php include('header.html'); ?>
        <ion-content class="ion-padding">
            <form enctype="multipart/form-data" method="post">
                <ion-text>
                    <h1>Create Account</h1>
                    Please fill in all the input fields and also note that the password has to have at least 3 characters, a valid email should be entered and the name and surname cannot be more than 15 characters long.
                </ion-text>
                <ion-list>
                    <ion-item>
                        <ion-label position="floating">Name</ion-label>
                        <ion-input name="name" clear-input="true"></ion-input>
                    </ion-item>
                    <ion-item>
                        <ion-label position="floating">Surname</ion-label>
                        <ion-input name="surname" clear-input="true"></ion-input>
                    </ion-item>
                    <ion-item>
                        <ion-label position="floating">Email</ion-label>
                        <ion-input name="email" clear-input="true"></ion-input>
                    </ion-item>
                    <ion-item>
                        <ion-label position="floating">Password</ion-label>
                        <ion-input type="password" name="password" clear-input="true"></ion-input>
                    </ion-item>
                    <ion-item>
                        <ion-label position="floating">Mobile number</ion-label>
                        <ion-input name="number" clear-input="true"></ion-input>
                    </ion-item>
                    <ion-item>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                        <input type="file" name="profilepic">
                    </ion-item>
                </ion-list>

                <input type="submit" name="back" value="Go Back" class="custom-button">
                <input type="submit" name="create" value="Create Account" class="custom-button">
            </form>
            <?php
            if (isset($_POST['back'])) {
                echo "<script>window.location.href='index.php';</script>";
            } else if (isset($_POST['create'])) {
                $name = trim($_POST['name']);
                $surname = trim($_POST['surname']);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $number = trim($_POST['number']);
                $profilepic = $_FILES['profilepic']['tmp_name'];

                if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($number) || empty($profilepic)) {
                    echo "<p style='color:red;'>Please fill all of the input fields!</p>";
                } else {
                    if (!is_string($name) || !is_string($surname)) {
                        echo "<p style='color:red;'>Name and surname should be strings!</p>";
                    } else if (strlen($name) > 15 || strlen($surname) > 15) {
                        echo "<p style='color:red;'>Name or username too long!</p>";
                    } else {
                        if (strlen($password) < 3) {
                            echo "<p style='color:red;'>Password has to be 3 or more characters long!</p>";
                        } else {
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                echo "<p style='color:red;'>Invalid email address!</p>";
                            } else {
                                require_once('dbconn.php');
                                $conn = connectToDb();
                                $name = mysqli_real_escape_string($conn, $name);
                                $surname = mysqli_real_escape_string($conn, $surname);
                                $email = mysqli_real_escape_string($conn, $email);
                                $password = mysqli_real_escape_string($conn, $password);
                                $number = mysqli_real_escape_string($conn, $number);
                                $query = "SELECT * FROM `tbl_accounts` WHERE `account_email`='$email' OR `account_number`='$number'";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<p style='color:red;'>Email or mobile number already taken!</p>";
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
                                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                    $sql = "INSERT INTO `tbl_accounts`(`account_name`, `account_surname`, `account_email`, `account_password`, `account_number`, `account_picture`) VALUES ('$name', '$surname', '$email', '$hashedPassword', '$number', '$newFilePath')";

                                    mysqli_query($conn, $sql) or die("<p style='color:red;'>Account could not be created!</p>");

                                    $_SESSION['account_index'] = mysqli_insert_id($conn);
                                    mysqli_close($conn);
                                    echo "<script>window.location.href='view.php';</script>";
                                }
                                mysqli_close($conn);
                            }
                        }
                    }
                }
            }
            ?>
        </ion-content>
        <?php include('footer.html'); ?>
    </ion-app>
</body>

</html>