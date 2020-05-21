$(document).ready(function(){
    console.log("app.js workingg");

    //SİGN UP CLİCKED    
    $("#signup").click(function(){
        console.log("signup button clicked"); 
        //İNPUTS CONTROL
        const name = $("#name").val();
        const email = $("#email").val();
        const password = $("#password").val();
        
        if(name.length == ""){
            $(".name").addClass("is-invalid");
        } else{
            $(".name").removeClass("is-invalid");
        }

        if(email.length == ""){
            $(".email").addClass("is-invalid");
        } else{
            $(".email").removeClass("is-invalid");
        }

        if(password.length == ""){
            $(".password").addClass("is-invalid");
        } else{
            $(".password").removeClass("is-invalid");
        }
        //Write To Db
        if(name.length != "" && email.length != "" && password.length != ""){
            $.ajax({
                type: "POST",
                url: "action/signup_action.php",
                data: {"name": name, "email": email, "role": 'customer', "password": password},
                dataType: 'JSON',
                success : function(feedback){
                    if(feedback.status==="error"){
                        $(".email").addClass("is-invalid");
                        $(".emailError").html(feedback.message);
                        console.log("signup error");
                    } else if(feedback.status ==="success"){
                        window.location = "login.php";
                        console.log("signup success");
                    }
                }
            })            
        }
    })

    //LOGİN BUTTON CLİCKED
    $("#login").click(function(){
        console.log("login button clicked");
        const email = $("#email").val();
        const password = $("#password").val();
        
        if(email.length == ""){
            $(".email").addClass("is-invalid");
        }else{
            $(".email").removeClass("is-invalid");
        }

        if(password.length == ""){
            $(".password").addClass("is-invalid");
        }else{
            $(".password").removeClass("is-invalid");
        }
        if(email.length != "" && password.length != ""){
            $.ajax({
                type:'POST',
                url: 'action/login_action.php',
                data: {'email': email, 'password': password}, 
                dataType : 'JSON',
                success: function(feedback){
                    console.log(feedback.status);
                    console.log("data type is ", Object.prototype.toString.call(feedback) , "value: " ,feedback);
                    if(feedback.status === "success"){
                        window.location = "home.php";
                    } else if(feedback.status === "passwordError"){
                        $(".password").addClass("is-invalid");
                        $(".passwordError").html(feedback.message);
                        $(".email").removeClass("is-invalid");
                        $(".emailError").html("");
                    }else if(feedback.status === "emailError"){
                        $(".password").removeClass("is-invalid");
                        $(".passwordError").html("");
                        $(".email").addClass("is-invalid");
                        $(".emailError").html(feedback.message);
                    }    
                }
            })
        }
    })
})