<?php

include('../db.php');
//$_POST output Array {"first_name":"zxz","last_name":"xzx","action":"insert","hidden_id":""}

if(isset($_POST["action"])){
    //insert işlemi
    if( $_POST["action"] == "insert" ){

        $query = "
		INSERT INTO books (book_name, book_category, author_name, book_page, book_price, book_brief, book_picture) VALUES ('".$_POST["book_name"]."', '".$_POST["category"]."', '".$_POST["author_name"]."', '".$_POST["book_page"]."', '" . $_POST["book_price"]."', '".$_POST["book_brief"]."','".$_POST["book_picture"]."')
        ";
        header('Content-type: text/html; charset=utf-8');
        $statement =  $connect -> prepare($query);
        $statement -> execute();
        //echo("<script>console.log('statement " . $statement . "');</script>");
        echo json_encode([ "status" => 'success', 'message' =>"you add book succesfully"]); 

    } 
 
    //Fetch işlemi //FOR UPDATE BUTTON
    if($_POST["action"] == "fetch_single"){
        $query = "
            SELECT * FROM books WHERE book_id = '".$_POST["book_id"]."'
        ";
        $statement = $connect -> prepare($query);
        $statement -> execute();
        $result = $statement -> fetchAll(); 
        foreach($result as $row){
            $output['book_name'] = $row['book_name'];
            $output['category'] = $row['book_category'];
            $output['author_name'] = $row['author_name'];
            $output['book_page'] = $row['book_page'];
            $output['book_price'] = $row['book_price'];
            $output['book_brief'] = $row['book_brief'];
            $output['book_picture'] = $row['book_picture'];

        }
        echo json_encode($output);  //cağrılan sayfaya json data olarak döner
    }

    //database update işemi
    //output $_POST // {"first_name":"kkazz","last_name":"kkaz","action":"update","hidden_id":"7"}
    if($_POST["action"] == "update"){
        //echo("<script>console.log('$_POST:::: " . json_encode($_POST) . "');</script>");
        $query = "
            UPDATE books
            SET book_name = '".$_POST["book_name"]."',
            book_category = '".$_POST["category"]."',
            author_name = '".$_POST["author_name"]."',
            book_page = '".$_POST["book_page"]."',
            book_price = '".$_POST["book_price"]."',
            book_brief = '".urldecode($_POST["book_brief"])."',
            book_picture = '".$_POST["book_picture"]."'

            WHERE book_id = '".$_POST["hidden_id"]."'

        ";
        $statement = $connect -> prepare($query);
        $statement -> execute();
        echo '<p>Data Updated<p>';
    }

    //database silme işlemi
    if($_POST["action"] == 'delete'){
        //"$_POST output:  {"id":"7","action":"delete"}"
        //echo("<script>console.log('$_POST:::: " . json_encode($_POST) . "');</script>");
        $query = "DELETE FROM books WHERE book_id = '".$_POST["book_id"]."'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Data Deleted</p>';
    }


}

?>

