<?php
include("../db.php");

if(isset($_POST["action"])){

    if($_POST["action"]== "searchBook" ){

        $query =  "SELECT * FROM books 
                WHERE book_name LIKE '%" . $_POST["search"] . "%' OR author_name LIKE '%"  . $_POST["search"] . "%' " ;

        $statement = $connect -> prepare($query);
        $statement -> execute();
        $rowArray = $statement -> fetchAll();
        $rowNum = $statement -> rowCount();

        $output = '
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Photo</th>
                    <th>Book Name</th>
                    <th>Author Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
        ';


        if($rowNum > 0){
            foreach( $rowArray as $row){
                $output .= '
                <tr>
                    
                    <td width="30%" height= 30%><img id="book_picture" src= '.$row["book_picture"].' height="100px"  width=150px></td></td>
                    <td width="30%">'.$row["book_name"].'</td>
                    <td width="30%">'.$row["author_name"].'</td>
                    <td width="5%">
                        <button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["book_id"].'">Edit</button>
                    </td>
                    <td width="5%">
                        <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["book_id"].'">Delete</button>
                    </td>
                </tr>
                ';
            }
        }else{
            $output .= '
                <tr>
                    <td colspan="4" align="center" >Data not found </td> 
                </tr>
            ';
        }

        $output .= '</table>';
        echo $output; 

    } 

    if($_POST["action"]== "searchUser" ){

        $query =  "SELECT * FROM users 
        WHERE name LIKE '%" . $_POST["search"] . "%' OR email LIKE '%"  . $_POST["search"] . "%' " ;

        $statement = $connect -> prepare($query);
        $statement -> execute();
        $rowArray = $statement -> fetchAll();
        $rowNum = $statement -> rowCount();

        $output = '
        <table class="table table-striped table-bordered">
            <tr>
                <th>Users Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>id</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        ';

        if($rowNum > 0){
            foreach( $rowArray as $row){
                $output .= '
                <tr>
                    
                    <td width="30%">'.$row["name"].'</td>
                    <td width="30%">'.$row["email"].'</td>
                    <td width="20%">'.$row["role"].'</td>
                    <td width="10%">'.$row["id"].'</td>
                    <td width="5%">
                        <button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["id"].'">Edit</button>
                    </td>
                    <td width="5%">
                        <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>
                    </td>
                </tr>
                ';
            }
        }else{
            $output .= '
                <tr>
                    <td colspan="4" align="center" >Data not found </td> 
                </tr>
            ';
        }

        $output .= '</table>';
        echo $output; 

    }




}

?>

<script>
    console.log(<?= json_encode("search.php working"); ?>);
</script>