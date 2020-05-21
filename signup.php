<?php
print("db class working");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--JS LİNKS--->    
    <title>SignUp</title>

        <link rel="stylesheet" href="jquery-ui.css">
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>
    
    <!--CSS LİNKS-->
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
</head>
<body>
    <div class="container"> 
        <div class="row">
            <div class="col-md-5 mx-auto mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>SignUp</h3>
                    </div>
                    <div class="card-body">        
                        <form>

                            <div class= "form-group">
                                <input type="text" id=name class= "form-control name" 
                                    placeholder="Name">
                                <div class="invalid-feedback" style="font-size:16px">Name is required</div>
                            </div>
                            
                            <div class="form-group">
                                <input type="email" id=email class= "form-control email" 
                                    placeholder="Email">
                                    <div class="invalid-feedback emailError" style="font-size:16px">Email is required</div>
                            </div>
                            
                            <div class="form-group">
                                <input type="password" id=password class= "form-control password" 
                                    placeholder="Password">
                                    <div class="invalid-feedback" style="font-size:16px">Password is required</div>
                            </div>

                            <div class="form-group">
                                <button type="button" id="signup" class="btn btn-info">Signup &rarr;</button>
                                <a href="login.php" style="float:right;margin-top:10px;">Already have an account ?</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>

<script>
    console.log(<?= json_encode("home.php working"); ?>);
</script> 