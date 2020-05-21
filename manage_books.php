	<?php
	include "db.php";
	if(!isset($_SESSION['id'])):
		header("location:login.php");
	endif; 
	?>

	<html>  
		<head>   
			<title>Manage Books</title>  
			<!--links-->

		</head>
		<body>  
			<link rel="stylesheet" href="jquery-ui/bootstrap.min.css" />
			<link rel="stylesheet" href="jquery-ui.css">
			<link rel="stylesheet" href="bootstrap.min.css" />
			<script src="jquery.min.js"></script>  
			<script src="jquery-ui.js"></script>

			<!--CSS LİNKS-->
			<link rel="stylesheet" href="css/styles.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			
			<!--crud list table-->
			<?php if(isset($_SESSION['id']) && isset($_SESSION['role']) ):
			if(($_SESSION['role']) != "customer"): ?>
			<div class="content">
							<div class="topnav">
								<a class="active" href="home.php">Home</a>
								<a type="button" id="add" class="btn btn-success btn-xs" name="add" value=""  style="margin-left: 20px">ADD Book</a>
								<div class="search-container">
									<form  method="post" id="search-form" >
										<input type="text" placeholder="Search.." name="search">
										<input type="hidden" id="idAction" name="action"  value="search" /> <!--url'de çıktı &action=insert -->
										<button type="submit" id="search-button" name="action" value="search"> <i class="fa fa-search"></i> </button>
									</form>
								</div>
							</div> 
				<br />
				<div class="table-responsive" id="book_table"> <!--table-->
				</div>
				<br />
			</div>
			<?php endif; ?>
			<?php endif; ?>
			
			

	

			<!--ADD USER FORM--->
			

			<div class="formContainer" style="display: none">

				<div class="addNewProduct">
				<button type="button" id="previous_button" name="previous" class="btn btn-success btn-xs" style="height: 40px; float: right">PREVİOUS</button> <!--add button-->

					<form method="post" id="addUser_form">
					
						<label><h2 class="title">Add New Book</h2></label>
						<br>
						
						<label for="pname">BOOK Name</label>
						<input type="text" id="bname" name="book_name" val="" placeholder="Book name..">
						<span id="check_bname" class="text-danger"> </span>
						<br>
						<label for="pname">BOOK Category</label>

						<div class="box">
							<select id="category">
								<option>Classic</option>
								<option>Drama</option>
								<option>Fable</option>
								<option>Fairy Tale</option>
								<option>Crime</option>
							</select>
						</div>
						<br>
						<label for="pname">Book Author</label>
						<input type="text" id="bauthor" name="author_name" val="" placeholder="Author name..">
						<span id="check_bauthor" class="text-danger"> </span>
						<br>
						<label for="pprice">Book Page</label>
						<input type="text" id="bpage" name="book_page" val="" placeholder="Book page..">
						<span id="check_bpage" class="text-danger"> </span>
						<br>
						<label for="pprice">Book Price</label>
						<input type="text" id="bprice" name="book_price" val="" placeholder="Book price..">
						<span id="check_bprice" class="text-danger"> </span>
						<br>
						<label for="pbrief">Book Brief</label>
						<textarea id="bbrief" name="book_brief" val="" placeholder="Describe book here..." rows="6" cols="40"></textarea>
						<span id="check_bbrief" class="text-danger"> </span>

						<div class="file-input">
							<input type="file" id="inpFile" name="inpFile" >
							<span class="button">Choose</span>
                            <span class="label" data-js-label></span>
						</div>

						<input type="hidden" id=hidden_id name="hidden_id" value=""> 
						<input type="hidden" id="idAction" name="action"  value="insert" /> <!--url'de çıktı &action=insert -->
						<div class="button-group" >
							<input type="submit" id="insert_button" class="btn btn-info" name="action" value="Insert"/>
						</div>

					</form>
				</div>
			</div>			

			<!----------------->
			<div id="showAlert_dia" title="Action">
			</div>
			
			<div id="deleteConfirm_dia" title="Confirmation">
			<p>Are you sure you want to Delete this data?</p>
			</div>

			<script src="js/manage-book.js" type="text/javascript"></script>
		</body>
	</html>  



