<?php
function db()
{
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $dbname = "users";
    $connection = mysqli_connect($host, $user, $pass, $dbname);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $connection;
}
function loginVal($email, $password)
{
    $email_error = "Please enter a valid email address.";
    $password_error = "Please enter a password with at least 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character.";
    $correct_password = "Enter the correct password";
    $correct_mail = "Enter the correct mail";
    $errors = array();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = $email_error;
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/", $password)) {
        $errors[] = $password_error;
    }

    if (!empty($errors)) {
        return $errors; 
    } else {
        $connection = db();
        $sql = "SELECT * FROM users WHERE email LIKE ?;";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            if (password_verify($password, $row['password'])) {
                session_start();
                if ($row['usertype'] == "admin") {
                    $id = $row["id"];
                    $_SESSION["id"] = $id;
                    redirect("admin/admin");
                }
                if ($row['usertype'] == "user") {
                    $id = $row["id"];
                    $_SESSION["id"] = $id;
                    redirect("user/user");
                }
            } else {
                $errors[] = $correct_password;
            }
        } else {
            $errors[] = $correct_mail;
        }
    }

    return $errors;
}

function registerValidation($email, $password, $confirm_password, $phone)
{
    $errors = [];

    $email_error = "Please enter a valid email address.";
    $password_error = "Please enter a password with at least 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character.";
    $con_password_error = "Please enter a confirm password with at least 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character.";
    $confirm_password_error = "Password does not match.";
    $phone_error = "Please enter a valid phone number with 10 digits.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = $email_error;
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/", $password)) {
        $errors[] = $password_error;
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/", $confirm_password)) {
        $errors[] = $con_password_error;
    }

    if (!($password == $confirm_password)) {
        $errors[] = $confirm_password_error;
    }

    if (!preg_match("/^\+[1-9][0-9]{0,2}[-\s]?[1-9][0-9]{9}$/", $phone)) {
        $errors[] = $phone_error;
    }

    if (empty($errors)) {
        return true;
    } else {
        return $errors;
    }
}
function exists($email){
    $errors = [];
    $email_error="Email Does not exist";
    $connection = db();
    $sql = "SELECT * FROM users WHERE email LIKE ?;";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            return true; 
        } else {
            $errors[] = $email_error;  
            return $errors;
        }
}
function updatePass($email, $password, $confirm_password)
{
    $errors = [];
    $password_error = "Please enter a password with at least 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character.";
    $con_password_error = "Please enter a confirm password with at least 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character.";
    $confirm_password_error = "Password does not match.";
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/", $password)) {
        $errors[] = $password_error;
    }
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/", $confirm_password)) {
        $errors[] = $con_password_error;
    }
    if (!($password == $confirm_password)) {
        $errors[] = $confirm_password_error;
    }
    if (!empty($errors)) {
        return $errors;
    } 
    else {
        $connection = db();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE email = ?;";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $hash, $email);
        mysqli_stmt_execute($stmt);
        return true;
    }
}
