<?php
	include "db.php";
	if(!isset($_SESSION['id'])):
		header("location: login.php");
	endif; 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Users</title>
    <!--links-->
			<!--LİNKSS-->
        <link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>

			<!--CSS LİNKS-->
			<link rel="stylesheet" href="jquery-ui/bootstrap.min.css" />
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<link rel="stylesheet" href="css/styles.css">


</head>
<body>

			<!--crud list table-->
			<?php if(isset($_SESSION['id']) && isset($_SESSION['role']) ): 
			if(($_SESSION['role']) != "customer"): ?>
			<div class="content">

				<div class="topnav">
                    <a class="active" href="home.php">Home</a>
                    <div class="search-container">
								<form  method="post" id="search-form" >
									<input type="text" placeholder="Search.." name="search">

									<input type="hidden" id="idAction" name="action"  value="search" /> <!--url'de çıktı &action=insert -->
									<button type="submit" id="search-button" name="action" value="search"> <i class="fa fa-search"></i> </button>
								</form>
							</div>
				</div>

				<br />
				<div class="table-responsive" id="user_table"> <!--table-->
				</div>
				<br />
			</div>
			<?php endif; ?>
			<?php else: ?>
				<p>You must login and admin</p>
			<?php endif; ?>


			<!--ADD USER FORM--->
			<div class="formContainer" style="display: none">

				<div class="user_form">
				<button type="button" id="previous_button" name="previous" class="btn btn-success btn-xs" style="height: 40px; float: right">PREVİOUS</button> <!--add button-->

					<form method="post" id="addUser_form">
					
						<label><h2>Edit Users</h2></label>
			 			<br>
						
						<label for="uname">User Name</label>
						<input type="text" id="uname" name="user_name" val="" placeholder="User name..">
						<span id="check_uname" class="text-danger"> </span>
						<br>
						<label for="uemail">User Eposta</label>
						<input type="text" id="uemail" name="user_email" val="" placeholder="User email..">
						<span id="check_uemail" class="text-danger"> </span>
						<br>
						<label for="urole">User Role</label>
						<br>
						<input type="radio" id="urole" name="user_role" value="admin">admin<br>
 						<input type="radio" id="urole" name="user_role" value="customer">customer<br>
  						<input type="radio" id="urole" name="user_role" value="editor">editor<br><br>


						<input type="hidden" id=hidden_id name="hidden_id" value=""> 
						<input type="hidden" id="idAction" name="action"  value="insert" /> <!--url'de çıktı &action=insert -->
						<div class="button-group" >
							<input type="submit" id="insert_button" class="btn btn-info" name="action" value="Insert"/>
						</div>

					</form>
				</div>
            </div>	
            
			<!--------alert dialog--------->
			<div id="showAlert_dia" title="Action">
			</div>
			
			<div id="deleteConfirm_dia" title="Confirmation">
			    <p>Are you sure you want to Delete this data?</p>
			</div>


			<script src="js/manage-user.js"></script>
</body>
</html>