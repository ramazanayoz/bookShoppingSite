$(document).ready(async function(){ 
 


    displayShipingform();
    initState();

    function initState(){
        var totalNum = JSON.parse(sessionStorage.getItem("totalCartNum")); 
        console.log(totalNum);
        if(totalNum == null){
            totalNum = 0;
          }
          $("#cartNum").text( totalNum['num']) ;
    }

    function displayShipingform(){
        var inCart = sessionStorage.getItem('incart'); //bellekten al
        inCart = JSON.parse(inCart);
        console.log(inCart);
        var cartCostTotal = 0;
        if(inCart){
            Object.values(inCart).map(item => {  // json array yapısını iterate etmek için map kullanılır
                cartCostTotal +=  Number(item.price)* Number(item.inCart)
            });
        }
        console.log("cart cost total", cartCostTotal);
        
        addresscontainer = document.querySelector(".addresscontainer");
        addresscontainer.style.display = "block";
        
        document.querySelector(".Yorder_totalCost").innerText=`$${cartCostTotal}.00` ;
        
        sameBillingAaddress();
        
        document.querySelector(".shipping_placeholder")
            .addEventListener('click', ()=>{
            credCartCheckout();
            });
    }
    
    
    function sameBillingAaddress(){ 
      console.log("sameBillingAaddress working");
      //billing bilgileri alınır
      var fieldset=document.querySelector(".billingform");
      var tempdiv = document.querySelector(".billingformdiv");
      var div = tempdiv;
      var billingchecked = document.querySelector(".billingchecked");
    
      billingchecked.addEventListener('click', () =>{ 
      // console.log("clicked");
          if(div){     // if same billing address selected 
          // console.log("child deleted:");
              div=div.remove();
    
          }else{ // if same billing address unselected 
              //console.log("child added")
              fieldset.appendChild(tempdiv);
              div = tempdiv;
          }    
    
      });
    
    }
    
    function credCartCheckout(){
        document.querySelector(".addresscontainer").style.display="none";
        let creditCartCeckout= document.querySelector(".creditCartCeckout");
        creditCartCeckout.innerHTML = `
        <div class="gridContainer">
        
        <div class="creditCard">
        <div class="visaLogo">
            <svg class="visa" enable-background="new 0 0 291.764 291.764" version="1.1" viewbox="5 70 290 200" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
            <path class="svgcolor" d="m119.26 100.23l-14.643 91.122h23.405l14.634-91.122h-23.396zm70.598 37.118c-8.179-4.039-13.193-6.765-13.193-10.896 0.1-3.756 4.24-7.604 13.485-7.604 7.604-0.191 13.193 1.596 17.433 3.374l2.124 0.948 3.182-19.065c-4.623-1.787-11.953-3.756-21.007-3.756-23.113 0-39.388 12.017-39.489 29.204-0.191 12.683 11.652 19.721 20.515 23.943 9.054 4.331 12.136 7.139 12.136 10.987-0.1 5.908-7.321 8.634-14.059 8.634-9.336 0-14.351-1.404-21.964-4.696l-3.082-1.404-3.273 19.813c5.498 2.444 15.609 4.595 26.104 4.705 24.563 0 40.546-11.835 40.747-30.152 0.08-10.048-6.165-17.744-19.659-24.035zm83.034-36.836h-18.108c-5.58 0-9.82 1.605-12.236 7.331l-34.766 83.509h24.563l6.765-18.08h27.481l3.51 18.153h21.664l-18.873-90.913zm-26.97 54.514c0.474 0.046 9.428-29.514 9.428-29.514l7.13 29.514h-16.558zm-160.86-54.796l-22.931 61.909-2.498-12.209c-4.24-14.087-17.533-29.395-32.368-36.999l20.998 78.33h24.764l36.799-91.021h-24.764v-0.01z" fill="#A9CBDC"></path>
            <path class="svgtipcolor" d="m51.916 111.98c-1.787-6.948-7.486-11.634-15.226-11.734h-36.316l-0.374 1.686c28.329 6.984 52.107 28.474 59.821 48.688l-7.905-38.64z" fill="#DDEAF1"></path>
            </svg>
        </div>
        <div class="chipLogo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 230 384.4 300.4" width="38" height="70">
            <path d="M377.2 266.8c0 27.2-22.4 49.6-49.6 49.6H56.4c-27.2 0-49.6-22.4-49.6-49.6V107.6C6.8 80.4 29.2 58 56.4 58H328c27.2 0 49.6 22.4 49.6 49.6v159.2h-.4z" data-original="#FFD66E" data-old_color="#00FF0C" fill="rgb(237,237,237)"/>
            <path d="M327.6 51.2H56.4C25.2 51.2 0 76.8 0 107.6v158.8c0 31.2 25.2 56.8 56.4 56.8H328c31.2 0 56.4-25.2 56.4-56.4V107.6c-.4-30.8-25.6-56.4-56.8-56.4zm-104 86.8c.4 1.2.4 2 .8 2.4 0 0 0 .4.4.4.4.8.8 1.2 1.6 1.6 14 10.8 22.4 27.2 22.4 44.8s-8 34-22.4 44.8l-.4.4-1.2 1.2c0 .4-.4.4-.4.8-.4.4-.4.8-.8 1.6v74h-62.8v-73.2-.8c0-.8-.4-1.2-.4-1.6 0 0 0-.4-.4-.4-.4-.8-.8-1.2-1.6-1.6-14-10.8-22.4-27.2-22.4-44.8s8-34 22.4-44.8l1.6-1.6s0-.4.4-.4c.4-.4.4-1.2.4-1.6V64.8h62.8v72.4c-.4 0 0 .4 0 .8zm147.2 77.6H255.6c4-8.8 6-18.4 6-28.4 0-9.6-2-18.8-5.6-27.2h114.4v55.6h.4zM13.2 160H128c-3.6 8.4-5.6 17.6-5.6 27.2 0 10 2 19.6 6 28.4H13.2V160zm43.2-95.2h90.8V134c-4.4 4-8.4 8-12 12.8h-122V108c0-24 19.2-43.2 43.2-43.2zm-43.2 202v-37.6H136c3.2 4 6.8 8 10.8 11.6V310H56.4c-24-.4-43.2-19.6-43.2-43.2zm314.4 42.8h-90.8v-69.2c4-3.6 7.6-7.2 10.8-11.6h122.8v37.6c.4 24-18.8 43.2-42.8 43.2zm43.2-162.8h-122c-3.2-4.8-7.2-8.8-12-12.8V64.8h90.8c23.6 0 42.8 19.2 42.8 42.8v39.2h.4z" data-original="#005F75" class="active-path" data-old_color="#005F75" fill="rgba(0,0,0,.4)"/>
            </svg>
        </div>
        <ul class="ccList">
            <li> </li>
        </ul>
        <h4 class="name"> </h4>
        <h4 class="year">   </h4>
        </div>
        
        <form action="#" id="paymentForm">
        <h6>Payment Details</h6>
        <div class="inputCon" id="name" data-top="Name on Card">
            <input type="text" placeholder="Full Name"/>
        </div>
        <div class="inputCon" id="cardNum" data-top="Card Number" title = "type in the card number without spaces">
            <input type="text" placeholder="4567 3456 3456 3456"/>
        </div>
        <div class="inputCon" id="validYear" data-top="Valid Through">
            <input type="text" placeholder="09/20"/>
        </div>
        <div class="inputCon" id="cvv" data-top="CVV">
            <input type="text" placeholder="444"/>
        </div>
        <button onclick="document.location.href='home.php'">pay<span>Complete</span></button>
        </form>
        </div>
        `;
    }
    
});