

$(document).ready(function(){  
 
  totalNum = JSON.parse(sessionStorage.getItem("totalCartNum")); 
  if(totalNum == null){
    totalNum = 0;
  }
  $("#cartNum").text( totalNum['num']) ;

  loadProducts();

  //--------------LOAD PRODUCTS
  function loadProducts(){  
    $.ajax({
      url: 'fetch/fetch_home.php',
      method: "POST",
      data:{category:"All"},
      success: async function(data){
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
      success: async function(data){ 
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
      success: async function(data){ 
          $(".container").html(data);
      }
    })
  });



  //-------------------------HW1 DEN KALMA SEPET İŞLEMİ İÇİN

  $(document).on('click', ".add-cart", function(){
    var jsonArrayobject;
    jsonArrayobject = JSON.parse(sessionStorage.getItem("incart"));
    var totalCartNum;
    var totalNum;

    img = $(this).closest('.image').children('img')[0];
    var img = $(img).attr('src');
    var book_id = $(this).closest('.image').children('.cart1')[0];
    book_id = $(book_id).attr("id");
    var name = $(this).closest('.image').children('h3')[0].innerText;
    var price = $(this).closest('.image').children('h3')[1].innerText;
    price = price.substring(0, price.indexOf(','));
    price = price.match(/\d/g);
    price = price.join("");

    var xproduct = new XProduct(name,price,img,book_id);
    if(jsonArrayobject == null){
        xproduct.inCart = 1;
        jsonArrayobject = { [xproduct.id]:  xproduct };
        
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
  });
    
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
        <button onclick="hideCartPage()">Continue to shop</button>
        <button onclick="displayShipingform()">Buy</button>
      </div>
    `;
  }
  
} 

$(document).ready(function(){

  //----------------DECREASE CLİCKED
  $(document).on("click", ".decrease", function(){
    console.log("decrease clicked");
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

        incartJson[id].inCart  += 1;
        incartJson = JSON.stringify(incartJson);
        sessionStorage.setItem("incart", incartJson);
        displayCart();
         
   });

   //------------------DELETE CLİCKED
  $(document).on("click", ".delete", function(){
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