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
                    <a href="#" id="sepet"">
                        <ion-icon name = "basket"></ion-icon>Cart<span id="cartNum">0</span>
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

    </div>

        <!--SHİPPİNG ADDRESS FORM -->
        <div class="addresscontainer">

          <div class="title">
                <h2>Product Order Form</h2>
          </div>
          <div class="d-flex">
            <form action="" method="" id="addressForm">
              <label>
                <span class="fname">First Name <span class="required">*</span></span>
                <input type="text" name="fname" required>
              </label>
              <label>
                <span class="lname">Last Name <span class="required">*</span></span>
                <input type="text" name="lname" required>
              </label>
              <label>
                <span>Company Name (Optional)</span>
                <input type="text" name="cn" >
              </label>
              <label>
                <span>Country <span class="required">*</span></span>
                <select name="selection" >
                  <option value="BEL">Belgium</option>
                  <option value="BLZ">Belize</option>
                  <option value="BMU">Bermuda</option>
                  <option value="ZWE">Zimbabwe</option>
                </select>
              </label>
              <label>
                <span>Street Address <span class="required">*</span></span>
                <input type="text" name="houseadd" placeholder="House number and street name" required>
              </label>
              <label>
                <span>&nbsp;</span>
                <input type="text" name="apartment" placeholder="Apartment, suite, unit etc. (optional)" required>
              </label>
              <label>
                <span>Town / City <span class="required">*</span></span>
                <input type="text" name="city" required> 
              </label>
              <label>
                <span>State / County <span class="required">*</span></span>
                <input type="text" name="city" required> 
              </label>
              <label>
                <span>Postcode / ZIP <span class="required">*</span></span>
                <input type="text" name="city" required> 
              </label>
              <label>
                <span>Phone <span class="required">*</span></span>
                <input type="tel" name="city" required> 
              </label>
              <label>
                <span>Email Address <span class="required">*</span></span>
                <input type="email" name="city" required> 
              </label>
              <input type="submit" id="submit-form" style="display: none;" class="require-billing"  />
    
              <input type="checkbox" name="" id="same-address" class="billingchecked">
              <label for="same-address" class="billing-same">Billing Address is the Same as Shipping</label>
    
              <!--billing form-->
              <fieldset class="billingform">
                <div class="billingformdiv">
    
                    <label>
                      <span class="fname">First Name <span class="required">*</span></span>
                      <input type="text" name="fname" required>
                    </label>
                    <label>
                      <span class="lname">Last Name <span class="required">*</span></span>
                      <input type="text" name="lname" required>
                    </label>
                    <label>
                      <span>Company Name (Optional)</span>  
                      <input type="text" name="cn" >
                    </label>
                    <label>
                      <span>Country <span class="required">*</span></span>
                      <select name="selection">
                        <option value="BEL">Belgium</option>
                        <option value="BLZ">Belize</option>
                        <option value="BMU">Bermuda</option>
                        <option value="ZWE">Zimbabwe</option>
                      </select>
                    </label>
                    <label>
                      <span>Street Address <span class="required" >*</span></span>
                      <input type="text" name="houseadd" placeholder="House number and street name" required>
                    </label>
                    <label>
                      <span>&nbsp;</span>
                      <input type="text" name="apartment" placeholder="Apartment, suite, unit etc. (optional)" required>
                    </label>
                    <label>
                      <span>Town / City <span class="required">*</span></span>
                      <input type="text" name="city" required> 
                    </label>
                    <label>
                      <span>State / County <span class="required">*</span></span>
                      <input type="text" name="city" required > 
                    </label>
                    <label>
                      <span>Postcode / ZIP <span class="required">*</span></span>
                      <input type="text" name="city" required> 
                    </label>
                    <label>
                      <span>Phone <span class="required">*</span></span>
                      <input type="tel" name="city" required> 
                    </label>
                </div>
              </fieldset>
              
            </form>
    
    
            <div class="Yorder">
              <table>
                <tr>
                  <th colspan="2">Your order</th>
                </tr>
                <tr>
                    
                </tr>
                <tr>
                  <td>Subtotal</td>
                  <td class="Yorder_totalCost">$0.00</td>
                </tr>
                <tr>
                  <td>Shipping</td>
                  <td>Free shipping</td>
                </tr>
              </table><br>
              <div>
                <input type="radio" name="dbt" value="dbt" checked> Direct Bank Transfer
              </div>
              <p>
                  Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
              </p>
              <div>
                <input type="radio" name="dbt" value="cd"> Cash on Delivery
              </div>
              <div>
                <input type="radio" name="dbt" value="cd"> Wire transfer 
              </div>
              <div>
                <input type="radio" name="dbt" value="cd"> Credit card<span>
                <img src="https://www.logolynx.com/images/logolynx/c3/c36093ca9fb6c250f74d319550acac4d.jpeg" alt="" width="50">
                </span>
              </div>
              
              <button for="submit-form" tabindex="0" class="shipping_placeholder" >Place Order</button>
            </div><!-- Yorder -->
           </div><!--d-flex-->
          </div>

          <div class="creditCartCeckout">
            
          </div>


    <script src="js/payment.js"></script>

</body>
</html>
