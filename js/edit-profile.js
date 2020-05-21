

$(document).ready(function(){
    
    //------------------profile edit submit BUTTON CLİCKED
    $(document).on('submit', '.profile-edit-form', function(event){
        event.preventDefault();
        console.log("edit clicked");
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var id = $("#hidden_id").val();
        var formData = {"id":id, "name":name, "email":email, "password":password}
        console.log("FORMDATA: ",formData);
        $.ajax({
            url:"action/editProfile_action.php",
            method:"POST",
            data: formData,
            dataType:"json",
            success: function(data){
                console.log(data.status);
                if(data.status == "success"){
                    window.location = "home.php";
                }else{ 
                    if(data.status == "emailerror"){
                        $(".emailError").html(data.message);
                        $(".email").addClass("is-invalid");
                    }
                }
            } 
        });
    });

    
});