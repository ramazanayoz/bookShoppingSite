<?php

include('../db.php');
//$_POST output Array {"first_name":"zxz","last_name":"xzx","action":"insert","hidden_id":""}

if(isset($_POST["action"])){

    //Fetch işlemi //FOR UPDATE BUTTON
    if($_POST["action"] == "fetch_single"){
        $query = "
            SELECT * FROM users WHERE id = '".$_POST["user_id"]."'
        ";
        $statement = $connect -> prepare($query);
        $statement -> execute();
        $result = $statement -> fetchAll();
        foreach($result as $row){
            $output['name'] = $row['name'];
            $output['email'] = $row['email'];
            $output['role'] = $row['role'];
            $output['id'] = $row['id'];
        }
        echo json_encode($output);  //cağrılan sayfaya json data olarak döner
    }

    //database update işemi
    //output $_POST // {"first_name":"kkazz","last_name":"kkaz","action":"update","hidden_id":"7"}
    if($_POST["action"] == "update"){
        //echo("<script>console.log('$_POST:::: " . json_encode($_POST) . "');</script>");
        $query = "
            UPDATE users
            SET name = '".$_POST["name"]."', 
            email = '".$_POST["email"]."',
            role = '".$_POST["role"]."'

            WHERE id = '".$_POST["user_id"]."'

        ";
        $statement = $connect -> prepare($query);
        $statement -> execute();
        if($statement){
            echo '<p>Data Updated<p>';
        }
    }




    //database silme işlemi
     if($_POST["action"] == 'delete'){
         //"$_POST output:  {"id":"7","action":"delete"}"
        //echo("<script>console.log('$_POST:::: " . json_encode($_POST) . "');</script>");
		$query = "DELETE FROM users WHERE id = '".$_POST["user_id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Deleted</p>';
     }
}

?>

