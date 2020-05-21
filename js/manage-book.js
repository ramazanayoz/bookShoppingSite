
$(document).ready(function(){  


    load_data();

    //--------LOAD TABLE DATA
    function load_data(){
        var user_id= "<?php if(isset($_SESSION['id'])) echo $_SESSION['id']; ?>" ;
        var role= "<?php if(isset($_SESSION['role'])) echo $_SESSION['role']; ?>" ;
        if(user_id !='' && role != "customer" ){
            $.ajax({
                url:"fetch/fetch_manage.php",  //verilerin fetch.php den alınacağını söylüyoruz
                method:"POST",
                data:{action: "fetchBookTable"},
                success:async function(data){ //gelen veri nasıl kullanılacak
                    //console.log("tableData: ",data);
                    $('#book_table').html(data); //#user_table içine bu html değerleri konur
                    
                }
            });
        }else{ 
            $('#book_table').html( '<tr> <td colspan="4" align="center" >You Must Login... </td> </tr>' ); 
        }
    }

    //---------ADD BOOK BUTTON
    $('#add').click(function(){
        $(".title").text("Add Book");
        $("#idAction").val("insert");	
        $("#addBook_dialog");
        $(".content").css("display","none");
        $(".formContainer").css("display","");
        $("#insert_button").val("INSERT");
        $('#addUser_form')[0].reset();
        $('.text-danger').html("");
        imageSrc = "";
    })

    //PREVİOUS BUTTON
    $('#previous_button').click(function(){
        $(".content").css("display","");
        $(".formContainer").css("display","none");
    })		


    //EDİT BUTTON make fetching
    $(document).on('click', '.edit',function(){
            console.log("edit button working");
            var id = $(this).attr("id"); //this seçilen edit kısmı
            var action = 'fetch_single';
            $(".title").text("Update Book");
            $('.text-danger').html("");
            $("#insert_button").val("Update");
            $(".content").css("display","none");
            $(".formContainer").css("display","");
            console.log("id ", id);
            $.ajax({
                url: "action/book_manage_action.php",
                method: "POST",
                data: {book_id:id, action:action},
                dataType: "json",
                success: function(data){
                    console.log("data ",data);
                    $("#bname").val(data.book_name);
                    $("#category").val(data.category);
                    $("#bauthor").val(data.author_name);
                    $("#bpage").val(data.book_page);
                    $("#bprice").val(data.book_price);
                    $("#bbrief").val(data.book_brief);
                    $("#insert_button").val("UPDATE");
                    $("#idAction").val("update");
                    console.log("#### bNama", bname);
                    imageSrc = data.book_picture ;
                    
                    $("#hidden_id").attr("value",id);
                    console.log("#hidden_id ",$("#hidden_id").attr("value")  );
                }
            });
    });



//GLOBABAL VAR for submit button
var isPaused = true; 
var imageSrc = "";


    //SUBMİT BUTTON---------------- 
    $("#addUser_form").on('submit', async function(event){
        console.log("submit button working");
        //VAR
        var bname = $("#bname").val();
        var bauthor = $("#bauthor").val();
        var bcategory = $("#category").val();
        var bpage = $("#bpage").val();
        var bprice = $("#bprice").val();
        var bbrief = $("#bbrief").val();
        isPaused = true;
        
        event.preventDefault();
        console.log("category: ",bcategory);
        await getImageSrc();
        var isInputsAvaliable = checkInputs();
        waitingForİmg();
        console.log("zzzzzzz ",isInputsAvaliable);
        async function waitingForİmg(){
            console.log("deneme");
            if(isPaused){
                console.log("ifde");
                setTimeout(async function(){waitingForİmg()},100); 
            }else{
                if(isInputsAvaliable && imageSrc){
                    console.log("elsede",imageSrc);
                    //var form_data = $('#addUser_form').serialize();
                    var hidden_id = $("#hidden_id").attr("value");
                    var action = $('#idAction').attr("value");
                    hidden_id = hidden_id ? hidden_id : ""; 
                    var form_data= {"book_name": bname, "author_name": bauthor, "book_page": bpage, "book_price": bprice, "book_brief":bbrief, "action":action, "hidden_id":hidden_id   , "book_picture": imageSrc, "category":bcategory};
                    console.log("SUBMİT clickded form_data...: "+hidden_id); 
                    await $.ajax({    
                            url:"action/book_manage_action.php",
                            method:"POST",
                            data:form_data,
                            success:function(data){
                                $('#showAlert_dia').html(data);
                                $('#showAlert_dia').dialog('open');
                                $(".content").css("display","");
                                $(".formContainer").css("display","none");
                                load_data();
                                console.log("data....... ", data);
                                
                            }
                    });	
                }
            }
        }
            
    });

    //CHECKINPUTS---------
    function checkInputs(){
        console.log("checkinputs working");
        bname = $("#bname").val();
        bauthor = $("#bauthor").val();
        bpage = $("#bpage").val();
        bprice = $("#bprice").val();
        bbrief = $("#bbrief").val();

        var nameError = errorControl(bname,"name");
        var priceError = errorControl(bprice,"price");
        var authorError = errorControl(bauthor,"name");
        var pageError = errorControl(bpage,"page");
        var briefError = errorControl(bbrief,"brief");
        
        console.log("asdasd:::",nameError);
        
        if(nameError || priceError || authorError || pageError ||  briefError){ 
            $("#check_bname").text(nameError);
            $("#check_bauthor").text(authorError);
            $("#check_bprice").text(priceError);
            $("#check_bpage").text(pageError);
            $("#check_bbrief").text(briefError);
            return false;
        } else {return true; }
        
    }


    //GETIMAGESRC------------
    async function getImageSrc(){
            var picsrc="";

            let inpFile = document.getElementById("inpFile");

        //reading picture file
        //console.dir(inpFile.files[0], {depth: null, colors: true}); //en iyisi budur	
            inpFile = inpFile.files[0];

            if(inpFile){
                const reader = new  FileReader();
                
                reader.readAsDataURL(inpFile);
                await reader.addEventListener("load", async function(){
                    //console.log("result: ", this.result)
                    picsrc = this.result;
                    controlImage=picsrc.match("data:image");
                    if(controlImage || imageSrc){
                        console.log("picsrc:::");
                        isPaused = false;
                        imageSrc = picsrc;
                    }else{
                        alert("You must select book ımage");
                        isPaused= false;

                    }
            });
            }else{
                imageSrc ? 	"" : alert("Please select image");
                isPaused= false;
            }
    }

    //ERRORCONTROL---------------
    function errorControl(val,type){
        var letters = /^[A-Za-z]+$/;
        try {
            if(type=="price"){
                if(isNaN(val)) throw `${type} must be number`
                if(val<1) throw `${type} must be at least 1`
                if(val>5000) throw `${type} more than 5000 not possible`
            }
            if(type=="page"){
                if(isNaN(val)) throw `${type} must be number`
                if(val<10) throw `${type} must be at least 10`
                if(val>10000) throw `${type} more than 10000 not possible`
            }
            if(type=="name"){
                if(!isNaN(val)) throw `${type} is invalid`
                if(2>val.length) throw `${type} must be at least 2 char`;
                if(70<val.length) throw `${type} can be max 70 char`;
            }
            if(type=="brief"){
                if(!isNaN(val)) throw `${type} is invalid`
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
                var action = 'delete';
                console.log("id", book_id);
                $.ajax({
                    url:"action/book_manage_action.php",
                    method:"POST",
                    data:{"book_id": book_id, "action": action},
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

    //---------------SEARCH BUTTON 
    $("#search-form").on("submit", function(event){
        event.preventDefault();
        console.log("search button clicked");
        form_data= $("#search-form").serialize();
        console.log(form_data);
        form_data += "&action=searchBook"
        $.ajax({
            url: "fetch/search_manage.php", 
            method: "POST",
            data: form_data,
            success: async function(data){
                $('#book_table').html(data);
                console.log(data);
            } 
        });
    });

});  