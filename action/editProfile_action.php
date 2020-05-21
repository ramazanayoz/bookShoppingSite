<?php
include "../db.php";

if( !isset($_SESSION['id'])):
    header("location: login_action.php");
endif;


if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['password'])){
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if($password != ''){ //boş değilse hashe çevir
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    }
    //kullanıcının id'si varmı databaseden kontrol edilir
    $isExistUser = $connect->prepare("SELECT email FROM users WHERE id != ?");
    $isExistUser->execute([$id]);
    if($isExistUser->rowCount() < 1 ){
        echo json_encode(['status' => 'error', 'message' => 'You must Login']);
    }else{
        if ($_SESSION['email'] != $email){ //email değiştirilmişsse
            //email önceden alınmışmı kontrol
            $checkEmail = $connect->prepare("SELECT email FROM users WHERE email = ?");
            $checkEmail->execute([$email]);
            if($checkEmail->rowCount() > 0 ){ 
                echo json_encode(['status' => 'emailerror', 'message' => 'Sorry this email is already taken']);
            }else {                
                $Query = $connect->prepare("UPDATE users  SET name= ?, email =?, password= IF(? = '' , password , ?)   WHERE id =? ");
                $Query->execute([$name, $email, $password, $password, $id]);
                if($Query){
                    $_SESSION['created'] = "Your account has been created successfully";
                    echo json_encode(['status' => 'success']);
                    unset($_SESSION['name']);
                    unset($_SESSION['email']);
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                }
            }
        }else{ //email değiştirilmemişse
            $Query = $connect->prepare("UPDATE users  SET name= ?, email =?, password= IF(? = '' , password , ?)   WHERE id =? ");
            $Query->execute([$name, $email, $password, $password, $id]);
            if($Query){
                $_SESSION['created'] = "Your account has been created successfully";
                echo json_encode(['status' => 'success']);
                 unset($_SESSION['name']);
                 unset($_SESSION['email']);
                 $_SESSION['name'] = $name;
                 $_SESSION['email'] = $email;
            }
        }   

    }
           
 }
 


?>