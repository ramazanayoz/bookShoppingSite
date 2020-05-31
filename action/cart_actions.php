<?php

include('../db.php'); 


$userId;
$bookId;

if(isset($_POST["action"])){
    
    if(($_POST["action"] == "addToCart" )){
        if(isset($_SESSION["id"])){
            $_SESSION["id"]; 
            $userId = $_SESSION["id"];
            $bookId = $_POST["book_id"];           
            //if book exist in cart, increase it. Otherwise insert it 
            $rowArray = existInDatabase($userId, $bookId);
            $cartId = $rowArray[0]["id"];
            if($cartId == 0){
                insertToDb($userId, $bookId);   
            }else{
                increaseCartElem($cartId);
            }
        }
    }

    if($_POST["action"] == "fetchTotalCartNum"){
        if(isset($_SESSION["id"])){
            $userId = $_SESSION["id"];
            $rowArray= fetchCartItems($userId);
            if($rowArray== 0){
                echo 0;
            } else{
                $totalNum = 0;
                foreach($rowArray as  $row){
                    $totalNum += $row["number"];
                } 
                echo $totalNum;
            }
        }
    }

    if($_POST["action"] == "fetchBooksInCart"){
        if(isset($_SESSION["id"])){
            $userId = $_SESSION["id"];
            $rowArray = fetchBooks($userId); 
            if($rowArray== 0){
                echo 0;
            } else{
                $myMixed= array();
                foreach($rowArray as  $row){

                    $temp = [ 
                        "id" => $row["book_id"], 
                        "img" => $row["book_picture"],   
                        "inCart" => $row["number"],   
                        "name" => $row["book_name"],   
                        "price" => $row["book_price"],                    
                          
                    ] ;     
                    
                    $arrayname[$row["book_id"]] = $temp;
                } 
                echo json_encode($arrayname);
            }
        }
    }

    if($_POST["action"] == "decreaseBooksInCarts"){
        if(isset($_SESSION["id"])){
            $_SESSION["id"]; 
            $userId = $_SESSION["id"];
            $bookId = $_POST["book_id"];           
            //if book exist in cart, increase it. Otherwise insert it 
            $rowArray = existInDatabase($userId, $bookId); 
            $cartId = $rowArray[0]["id"];
            $bookNum = $rowArray[0]["number"];
            if($bookNum <= 1){
                delete($cartId);  
            }else{
                decrease($cartId);
            }
        }
    }

    if($_POST["action"] == "deleteBooksInCarts"){
        if(isset($_SESSION["id"])){
            $_SESSION["id"]; 
            $userId = $_SESSION["id"];
            $bookId = $_POST["book_id"];           
            //if book exist in cart, increase it. Otherwise insert it 
            $rowArray = existInDatabase($userId, $bookId); 
            $cartId = $rowArray[0]["id"];
            delete($cartId);  
        }
    }
}




//-------FUNCTİONS
function existInDatabase($userId, $bookId){
    $sql = "SELECT * FROM cart WHERE user_id= '". $userId ."' and book_id = '". $bookId ."'";
    $statement = $GLOBALS['connect'] -> prepare($sql);
    $statement -> execute();
    $row_array = $statement -> fetchAll();
   // $id = $row_array -> i;
   if($statement -> rowCount() >0 ){
        return $row_array;
   }else{
       return 0;
   }
}

function insertToDb($userId, $bookId){
    try{
        $query = "INSERT INTO cart (user_id, book_id, number) VALUES ('".$userId."', '".$bookId."', 1)";
        $statement = $GLOBALS['connect'] -> prepare($query);
        $statement -> execute();
        echo "created succesfully". " "; 
    } catch (PDOException $e){ 
        echo "error: ".$e;
    }
     
}

function increaseCartElem($cartId){
    try{
        $query = " UPDATE cart SET number =  number+1  WHERE id = '".$cartId."' ";
        $statement = $GLOBALS['connect'] -> prepare($query);
        $statement -> execute();
        echo "created succesfully". " "; 
    } catch(PDOException $e){ 
        echo "error: ".$e;
    }    
}

function decrease($cartId){
    try{
        $query = " UPDATE cart SET number =  number-1  WHERE id = '".$cartId."' ";
        $statement = $GLOBALS['connect'] -> prepare($query);
        $statement -> execute();
        echo "created succesfully". " "; 
    } catch(PDOException $e){ 
        echo "error: ".$e; 
    }   
}


function delete($cartId){
    try{
        $query = " DELETE FROM cart WHERE id = '".$cartId."' ";
        $statement = $GLOBALS['connect'] -> prepare($query);
        $statement -> execute();
        echo "created succesfully". " "; 
    } catch(PDOException $e){ 
        echo "error: ".$e; 
    }   
}


function fetchCartItems($userId){
    try{
        $sql = "SELECT * FROM cart WHERE user_id= '". $userId ."' ";
        $statement = $GLOBALS['connect'] -> prepare($sql);
        $statement -> execute();
        $row_array = $statement -> fetchAll();
       // $id = $row_array -> i;
       if($statement -> rowCount() >0 ){
            return $row_array ;
       }else{
           return 0;
       }
    } catch(PDOException $e){
        echo "error: ".$e;
    }
}

function fetchBooks($userId){
    try{
        $sql = "SELECT books.book_id, books.book_name, books.book_price, books.book_picture, cart.number FROM cart LEFT OUTER JOIN books ON cart.book_id = books.book_id WHERE cart.user_id= '". $userId ."'  ";
        $statement = $GLOBALS['connect'] -> prepare($sql);
        $statement -> execute();
        $row_array = $statement -> fetchAll(); 
        if($statement -> rowCount() >0 ){
            return $row_array ;
       }else{
           return 0;
       }
    }catch(PDOException $e){
        echo "error: ".$e;
    }
}


?>