<?php
include "db.php";


//if(!isset($_SESSION['id'])):
//    header("location: action/login_action.php");
//endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <!--CSSlinks-->
    <link rel="stylesheet" href="css/styles.css">

    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--js links-->
        
        <link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>


            
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

    <title>Shopping Cart</title>
</head>

<body>

    <!--HEADER-->
    <header>
        <div class="overlay"></div>
        <nav>
            <h2>SHOP</h2>
            <ul>
                <li><a href="home.php" role="button">HOME</li>
                <?php if (isset($_SESSION['id'])): ?>
                    <li><a href="action/logout_action.php" role="button">LogOut</li>
                <?php else: ?>
                    <li><a href= "login.php">Login</li>
                <?php endif; ?>
                <li class="cart"> 
                    <a href="cart.php" id="sepet"">
                        <ion-icon name = "basket"> </ion-icon>Cart <span id="cartNum">0</span>
                    </a>
                </li> 
            </ul>
        </nav>
    </header>

    <!--TOPNAV--->
    <div class="topnav">
        
        <a class="active" href="home.php">Home</a>
        <?php if(isset($_SESSION['id']) && isset($_SESSION['role']) ): ?>
        <a href="edit_profile.php" class="edit-profile">Edit Profile</a>
        <?php if(($_SESSION['role']) != "customer"): ?> 
        <a href="manage_books.php" role="button" class="add_new_product" >Manage Books</a>
        <a href="manage_users.php" class="manage-users" role="button" >Manage Users</a>
        <?php endif; ?>
        <?php endif; ?>

        <div class="selectdiv">
            <label>
            <select id="category">
                <option selected> Select Category </option>
                    <option>All</option>
                    <option>Classic</option>
                    <option>Drama</option>
                    <option>Fable</option>
                    <option>Fairy Tale</option>
                    <option>Crime</option>
            </select>
        </label>
        </div>
        

        <div class="search-container">
            <form id="search">
            <input type="text" id="searchedText" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>


    <content>
        <!-PRODUCT TABLE-->
        <div class="wrapper">
            <div class="container">
          

            </div>
        </div>
    </content> 
    
    
    <script src="js/main.js"></script>

</body>
</html>
