<?php
include "../db.php";

if(isset($_POST['name']) && isset($_POST['email']) && isset( $_POST['role'] ) && isset($_POST['password'])  ){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $checkEmail = $connect->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->execute([$email]);
    if($checkEmail->rowCount() > 0 ){
        echo json_encode(['status' => 'error', 'message' => 'Sorry this email is already taken']);

    } else {
     $Query = $connect->prepare("INSERT INTO users (name, email, role, password) VALUES (?,?,?,?)");
     $Query->execute([$name, $email, $role, $password]);
     if($Query){
         $_SESSION['created'] = "Your account has been created successfully";
         echo json_encode(['status' => 'success']);
     }
    }
}

?>

