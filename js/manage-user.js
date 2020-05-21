$(document).ready(function(){  

 
    load_data(); 

    //--------LOAD TABLE DATA
    function load_data(){
            $.ajax({
                url:"fetch/fetch_manage.php",  //verilerin fetch.php den alınacağını söylüyoruz
                method:"POST",
                data: {"action":"fetchUserTable"},
                success:async function(data){ //gelen veri nasıl kullanılacak
                    //console.log("tableData: ",data);
                    $('#user_table').html(data); //#user_table içine bu html değerleri konur
                    
                }
            });
    }


    //PREVİOUS BUTTON
    $('#previous_button').click(function(){
        $(".content").css("display","");
        $(".formContainer").css("display","none");
    })		


    //EDİT BUTTON inputs fetching 
    $(document).on('click', '.edit',function(){
            console.log("edit button working");
            var id = $(this).attr("id"); //this seçilen edit kısmı
            $('.text-danger').html("");
            $("#insert_button").val("Update");
            $(".content").css("display","none");
            $(".formContainer").css("display","");
            console.log("edit clicked ", id);
            $.ajax({
                url: 'action/user_manage_action.php',
                method: "POST",
                data: {user_id:id, action:"fetch_single"},
                dataType: "json",
                success: function(data){
                    console.log(",,,,,, ",data);
                    $("#uname").val(data.name);
                    $("#uemail").val(data.email);
                    $("input[name=user_role][value=" + data.role + "]").attr('checked', 'checked');                    
                    $("#hidden_id").attr("value",id);
                    console.log("#hidden_id ",$("#hidden_id").attr("value")  );
                }
            });
    });



//GLOBABAL VAR for submit button

    //SUBMİT BUTTON---------------- 
    $("#addUser_form").on('submit', function(event){
        console.log("submit button working");
        //VAR
        var uname = $("#uname").val();
        var uemail = $("#uemail").val();
        var urole = $("input[name='user_role']:checked").val();
        console.log("urole: ", urole);
        event.preventDefault(); 
        var isInputsAvaliable = checkInputs();
                if(isInputsAvaliable ){
                    var form_data = $('#addUser_form').serialize();
                    var hidden_id = $("#hidden_id").attr("value");
                    hidden_id = hidden_id ? hidden_id : ""; 
                    form_data= {"name": uname, "email": uemail, "role": urole, "action":"update", "user_id":hidden_id };
                    console.log("SUBMİT clickded form_data...: ",form_data); 
                    $.ajax({    
                            url:"action/user_manage_action.php",
                            method:"POST",
                            data:form_data,
                            success:function(data){
                                $('#showAlert_dia').html(data);
                                $('#showAlert_dia').dialog('open');
                                $(".content").css("display","");
                                $(".formContainer").css("display","none");
                                load_data();
                                
                            }
                    });	
                }
            
    });
    
    //CHECKINPUTS for submit button---------
    function checkInputs(){
        console.log("checkinputs working");
        uname = $("#uname").val();
        uemail = $("#uemail").val();


        var nameError = errorControl(uname,"name");
        var authorError = errorControl(uemail,"name");

        
        if(nameError  || authorError){ 
            $("#check_uname").text(nameError);
            $("#check_bauthor").text(authorError);
            return false;
        } else {return true; }
        
    }

    //ERRORCONTROL---------------
    function errorControl(val,type){
        var letters = /^[A-Za-z]+$/;
        try {

            if(type=="name"){
                if(!isNaN(val)) throw `${type} is invalid`
                if(2>val.length) throw `${type} must be at least 2 char`;
                if(70<val.length) throw `${type} can be max 70 char`;
            }

            return "";
                
        } catch (error) {
                return error;
        }
    }

    
    //---------SHOW ALERT
    $('#showAlert_dia').dialog({
        autoOpen:false
    });
    

    //-----------CLİCKED DELETE BUTTON
    $(document).on('click', '.delete', function(){
        var book_id = $(this).attr("id");
        $('#deleteConfirm_dia').data('book_id', book_id).dialog('open');
    });

    
    //-------------DELETE CONFİRM  DİALOG
    $('#deleteConfirm_dia').dialog({
        autoOpen:false,
        modal: true, 
        buttons:{
            Ok : function(){
                console.log("this,,,,",this);
                var book_id =  $(this).data('book_id');
                console.log("asda", book_id);
                $.ajax({
                    url:"action/user_manage_action.php",
                    method:"POST",
                    data:{"user_id": book_id, "action": "delete"},
                    success:function(data)
                    {
                        $('#deleteConfirm_dia').dialog('close');
                        $('#showAlert_dia').html(data);
                        $('#showAlert_dia').dialog('open');
                        location.reload();
                    }
                });
            },
            Cancel : function(){
                $(this).dialog('close');
            }
        }	
    });

    //---------------SEARCH BUTTON  clicked
    $("#search-form").on("submit", function(event){
        event.preventDefault();
        console.log("search button clicked");
        form_data= $("#search-form").serialize();
        console.log(form_data); 
        form_data += "&action=searchUser"
        $.ajax({
            url: "fetch/search_manage.php",
            method: "POST", 
            data: form_data,
            success: async function(data){
                $('#user_table').html(data);
                console.log(data);
            } 
        });
    });

});  