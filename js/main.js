

$(document).ready(async function(){ 
 
  initiliazeTotalCardNum();
  await fetchBookInCart();
  loadProducts();


  //-----------INITILİAZE  TOTAL CART NUM
  function initiliazeTotalCardNum(){
    var totalNum = JSON.parse(sessionStorage.getItem("totalCartNum")); 
    //totalNum = Number(totalNum);
    if(totalNum == null){
      totalNum = 0;
    }
    $("#cartNum").text( totalNum['num']) ;
    getTotalCartNumFromDb();
  }

  //-----------FETCH BOOKS İN THE CART FROM DB  AND SET TO SESSİONSTRAGE
  async function fetchBookInCart(){
    $.ajax({
      url: "action/cart_actions.php",
      method: "POST",
      data:{"action": "fetchBooksInCart"},
      dataType:"JSON",
      success: function(data){
        console.log('totalCartNum $data.. ');
        console.log(data);
        data= JSON.stringify(data);
        if(data!=0){
          sessionStorage.setItem("incart", data);
          displayCart();
        }else{

        }
      }
    });    
  }

  //--------------------- DECREASE BOOK NUM İN CART FROM DB 
  function decreaseBookNumInCart(id){
    $.ajax({
      url: "action/cart_actions.php",
      method: "POST",
      data:{"action": "decreaseBooksInCarts", "book_id" : id},
      success: function(data){
        console.log("decreased clicked");
        console.log(data);
      }
    });     
  }

    //--------------------- INCREASE BOOK NUM İN CART FROM DB 
    function increaseBookNumInCart(book_id){
      $.ajax({
        url: "action/cart_actions.php",
        method: "POST",
        data:{"action": "addToCart", "book_id": book_id},
        //dataType: 'JSON',
        success: function(data){
          console.log(data);
        }
      });  
    }

    //--------------------- INCREASE BOOK NUM İN CART FROM DB 
    function deleteBookNumInCart(book_id){
      $.ajax({
        url: "action/cart_actions.php",
        method: "POST",
        data:{"action": "deleteBooksInCarts", "book_id": book_id},
        //dataType: 'JSON',
        success: function(data){
          console.log(data);
        }
      });  
    }


  //--------------LOAD PRODUCTS
  function loadProducts(){  
    $.ajax({
      url: 'fetch/fetch_home.php',
      method: "POST",
      data:{category:"All"},
      success: function(data){
        $(".container").html(data);
      }
    });
  }
  
  //--------------CATEGORY SELECTED
  $('#category').on('change', function() {
    console.log("category selected");
    var category = this.value;
    $.ajax({
      url:'fetch/fetch_home.php',
      method: "POST",
      data: {category: category},
      success: function(data){ 
          $(".container").html(data);  
      }
    })
  });

  //-------------SEARCH BUTTON
  $("#search").on('submit', function(event){
     event.preventDefault();
     var text = $("#searchedText").val(); 
     form_data= {"search": text};
    console.log("search clicked", form_data);
    $.ajax({
      url:'fetch/fetch_home.php',
      method: "POST",
      data: form_data,
      success: function(data){ 
          $(".container").html(data);
      }
    })
  });

  //------------GETTİNG TOTAL CART NUM FROM DB
   function getTotalCartNumFromDb() {
    //Get totalCartNum from db
    $.ajax({
      url: "action/cart_actions.php",
      method: "POST",
      data:{"action": "fetchTotalCartNum"},
      //dataType: 'JSON',
      success: function(data){
        console.log("totalCartNum" + data);
        if(data!=0){
          $("#cartNum").text( data);
          data=  parseInt(data);
          var totalNum = {["num"]: data };
          totalNum = JSON.stringify(totalNum);
          sessionStorage.setItem("totalCartNum", totalNum);
          return data;
        }
      }
    });
  }


  //-------------------------HW2  SEPET İŞLEMİ İÇİN
  $(document).on('click', ".add-cart", function(){

    var jsonArrayobject;
    var totalCartNum;
    var totalNum;    
    var img; 
    var book_id;   
    var name;
    var price;

    //initialize img, book_id, name, price, jsonArrayobject
    jsonArrayobject = JSON.parse(sessionStorage.getItem("incart"));
    img = $(this).closest('.image').children('img')[0];
    img = $(img).attr('src');
    book_id = $(this).closest('.image').children('.cart1')[0];
    book_id = $(book_id).attr("id");
    name = $(this).closest('.image').children('h3')[0].innerText;
    price = $(this).closest('.image').children('h3')[1].innerText;
    price = price.substring(0, price.indexOf(','));
    price = price.match(/\d/g);
    price = price.join(""); 

    var xproduct = new XProduct(name,price,img,book_id);
    if(jsonArrayobject == null){
        xproduct.inCart = 1;
        console.log( "$xproduct.id" );
        jsonArrayobject = {  [xproduct.id] :  xproduct }; //Y/:..
        totalNum = {["num"] : 1};
    }else{
        if(jsonArrayobject[xproduct.id] == undefined ){
          xproduct.inCart = 1;
          jsonArrayobject[xproduct.id] =  xproduct;
        }else{
          jsonArrayobject[xproduct.id].inCart += 1;
        }
        totalNum = JSON.parse(sessionStorage.getItem("totalCartNum"));
        totalNum["num"] += 1; 
    }
    $("#cartNum").text( totalNum['num']) ;
    jsonArrayobject = JSON.stringify(jsonArrayobject);
    sessionStorage.setItem("incart",jsonArrayobject);
    
    totalNum = JSON.stringify(totalNum);
    sessionStorage.setItem("totalCartNum", totalNum);

    //write to db when clicked  add to cart button
    increaseBookNumInCart(xproduct.id);

  });

    


displayCart();


function displayCart(){ //cart.html için
  //json arrayden ürün miktarını  ismini vs alıp html olarak gösterrir
  var productsOnPage=document.querySelector(".container");
  var productCartContainer=document.querySelector(".products-container");

  console.log("fonk displayCart working");
  let cartItems = sessionStorage.getItem("incart") //bellekten al
  cartItems = JSON.parse(cartItems); //json array formata çevrilir string json
  var cartCostTotal =0 ;

  let productContainer = document.querySelector(".products"); //boş bırakılan products kısıma ürünler listelenir
  console.log(cartItems);
  if(cartItems && productContainer ){
   // console.log("running ");
    productContainer.innerHTML= '';
    Object.values(cartItems).map(item => {  // json array yapısını iterate etmek için map kullanılır
      productContainer.innerHTML += //listelenilcek ürünlerini ayarlama
      `<div class="product"> 
        <ion-icon name="close-circle" class="delete" id= ${item.id}></ion-icon>
        <img src=${item.img} >
        <span>${item.name}</span>
      </div>
      <div class="price">$${item.price},00</div>  
      <div class = "quantity">
        <ion-icon class="decrease" name="arrow-dropleft-circle" id= ${item.id} ></ion-icon>
        <span>${item.inCart}</span>
        <ion-icon class="increase" name="arrow-dropright-circle" id= ${item.id} ></ion-icon>
      </div>
      <div class="total">
        $${item.inCart* item.price},00
      </div>
      
      `;
 
      cartCostTotal += parseInt(item.inCart)* parseInt(item.price); 
    });

    productContainer.innerHTML += `
      <div class="basketTotalContainer">
        <h4 class="basketTotalTitle">
          Basket Total
        </h4>
        <h4 class="basketTotal">
          $${cartCostTotal},00
        </h4>
      </div>
    `;
    
    productContainer.innerHTML +=`
      <div class="btn-group">
        <button onclick="document.location.href='home.php'" >Continue to shop</button>
        <button onclick="document.location.href='payment.php'">Buy</button>
      </div>
    `;
  }
  
} 



  //----------------DECREASE CLİCKED
  $(document).on("click", ".decrease", function(){
    console.log("decrease clicked");
    //for sessionStrage and ui part
    var incartJson= sessionStorage.getItem("incart");
    incartJson = JSON.parse(incartJson);
    id = $(this).attr("id");
    console.log(" ..", id );
    if(incartJson[id].inCart < 2 ){
      delete incartJson[id];
      incartJson =JSON.stringify(incartJson);
      sessionStorage.setItem("incart", incartJson);
      displayCart();
    }else{
      incartJson[id].inCart  -= 1;
      incartJson = JSON.stringify(incartJson);
      sessionStorage.setItem("incart", incartJson);
      displayCart();
    }

    totalNum = JSON.parse(sessionStorage.getItem("totalCartNum"));
    totalNum["num"] -= 1; 
    $("#cartNum").text( totalNum['num']) ;
    totalNum = JSON.stringify(totalNum);
    sessionStorage.setItem("totalCartNum", totalNum);
    //for db part
    decreaseBookNumInCart(id);

   });

   //----------------İNCREASE CLİCKED
   $(document).on("click", ".increase", function(){
    console.log("increase clicked");
     var incartJson= sessionStorage.getItem("incart");
     incartJson = JSON.parse(incartJson);
     id = $(this).attr("id");
     console.log(" ..", id );

        totalNum = JSON.parse(sessionStorage.getItem("totalCartNum"));
        totalNum["num"] += 1; 
        $("#cartNum").text( totalNum['num']) ;
        totalNum = JSON.stringify(totalNum);
        sessionStorage.setItem("totalCartNum", totalNum);

        incartJson[id].inCart  = Number(incartJson[id].inCart)+ 1;
        incartJson = JSON.stringify(incartJson);
        sessionStorage.setItem("incart", incartJson);
        displayCart();
        increaseBookNumInCart(id);
   });

   //------------------DELETE CLİCKED
  $(document).on("click", ".delete", function(){
    //for sessionStrage and ui part
    console.log("delete clicked");
    var incartJson= sessionStorage.getItem("incart");
    incartJson = JSON.parse(incartJson);
    id = $(this).attr("id");
    console.log(" ..", id );

    totalNum = JSON.parse(sessionStorage.getItem("totalCartNum"));
    totalNum["num"] -= incartJson[id].inCart ; 
    $("#cartNum").text( totalNum['num']) ;
    totalNum = JSON.stringify(totalNum);
    sessionStorage.setItem("totalCartNum", totalNum);

    delete incartJson[id];
    incartJson =JSON.stringify(incartJson);
    sessionStorage.setItem("incart", incartJson);
    displayCart();
    deleteBookNumInCart(id);
    
   });

});









class XProduct{
  constructor(name,price, img,id){
    this.name = name;
    this.price = parseInt(price);
    this.img = img;
    this.id = id;
    this.inCart = 0;
  }
}