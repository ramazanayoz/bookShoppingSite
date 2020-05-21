<?php

include('../db.php');
$total_rowNum ='';
$rowArray ='';
$output= '';

//------------------CATEGORY QUERY
if(isset($_POST['category']) ){
 
  if($_POST['category']=='All' || $_POST['category']=='Select Category' ){

    $query = "SELECT * FROM books";
    $statement = $connect -> prepare($query);
    $statement -> execute();
    $rowArray = $statement -> fetchAll();
    $total_rowNum = $statement -> rowCount();
    
    $output= '';

  }else{
    $query = " SELECT * FROM books WHERE book_category = '".$_POST["category"]."' ";
    $statement = $connect -> prepare($query);
    $statement -> execute();
    $rowArray = $statement -> fetchAll();
    $total_rowNum = $statement -> rowCount();
  
    $output= '';
  }

}

//-----------------SEARCH QUERY
if(isset($_POST['search'])){ 
  $query =  "SELECT * FROM books 
  WHERE book_name LIKE '%" . $_POST["search"] . "%' OR author_name LIKE '%"  . $_POST["search"] . "%' " ;


$statement = $connect -> prepare($query);
$statement -> execute();
$rowArray = $statement -> fetchAll();
$total_rowNum = $statement -> rowCount();
$output= '';


}

//-----------------FETHCHED
if($total_rowNum > 0){
    foreach($rowArray as $row){
        $output .= '
            <div class="image">
                <img src=" '.$row["book_picture"].' " alt=" '.$row["book_name"].' ">
                <h3>'.$row["book_name"].'</h3>
                <h3>$'.$row["book_price"].',00</h3>
                <a class="add-cart cart1" id="'. $row["book_id"] .'" class="add-cart" href="#">Add Cart</a>
                <div class="inside">
                    <div class="icon"><i class="material-icons">Details</i></div>
                    <div class="contents">
                        <h3> Brief Description </h3>
                        <p class=product-brief>
                        '.$row["book_brief"].'  </p>
                      <table>
                        <tr>
                          <th>Author</th>
                          <th>Page</th>
                        </tr>
                        <tr>
                          <td>'.$row["author_name"].'</td>
                          <td>'.$row["book_page"].'</td>
                        </tr>
                      </table>
                    </div>
                  </div>
            </div>
        ';
      //  echo("<script>console.log('PHP: " . json_encode($row) . "');</script>");

    }
}else{
    $output .= '<p> " Data not found"</p>
    ';
}

echo $output; //BY-U KISIM RETURN GİBİ DÜŞÜNÜLEBİLİR

?>

<script>
    console.log(<?= json_encode("fetch.php working"); ?>);
</script>