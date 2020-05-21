<?php 

include "../db.php";

if( isset($_POST['email']) && isset($_POST['password']) ){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $Query = $connect -> prepare("SELECT * FROM users WHERE email = ?");
    $Query -> execute([$email]);
    if($Query -> rowCount() > 0){ 
        $row = $Query -> fetch(PDO::FETCH_OBJ); //bilgiler databaseden çekiliyor
        $dbPassword = $row -> password;
        $name = $row -> name;
        $email = $row -> email; 
        $id = $row -> id;
        $role = $row -> role;
        if(password_verify($password, $dbPassword) ||  $password == $dbPassword ){
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
           echo json_encode([ "status" => 'success', 'message' =>"you login succesfully"]); 
        }else{
            echo json_encode(['status' => 'passwordError', 'message' => 'Your password is wrong']);
        }
    }else{
        echo json_encode(['status' => 'emailError', 'message' => 'Your email is wrong']);
    }
}

?>

