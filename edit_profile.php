<?php
include "db.php";
if( !isset($_SESSION['id'])):
    header("location: action/login_action.php");
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!--CSS LİNKS--->
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <!--JS LİNKS--->    
	<!--js links-->
        <link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>
</head>
<body>
    <div class="container"> 
        <div class="row">
            <div class="col-md-5 mx-auto mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Profile</h3>
                    </div>
                    <div class="card-body">        
                        <form class="profile-edit-form">
                            <a href="home.php" class="active"><button type="button" id="previous_button" name="previous" class="btn btn-success btn-xs" style="height: 40px; float: right">PREVİOUS</button></a> <!--add button-->

                            <div class= "form-group">
                                <input type="text" id=name class= "form-control name" 
                                    placeholder="Name" name="name" value= ' <?php echo $_SESSION['name'];?> '  >
                            </div>
                            
                            <div class="form-group">
                                <input type="text" id=email class= "form-control email" 
                                    placeholder="Email" name="email" value='<?php echo $_SESSION['email'];?>'>
                                    <div class="invalid-feedback emailError " style="font-size:16px"> </div>

                            </div>
                            
                            <div class="form-group">
                                <input type="password" id=password class= "form-control password" 
                                    placeholder="Password">
                            </div>

                            <div class="form-group">
                                <input type="hidden" id= hidden_id name="id" value=' <?php echo $_SESSION['id'];?> '  >
                                <button type="submit" id="editProfile" class="btn btn-info">Edit Profile &rarr;</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/edit-profile.js"></script>

</body>
</html>
