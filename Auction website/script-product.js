// Notification after a transaction or a bet
function buynotif(statut,price)
{
console.log(price);
if(statut==1){
alert("Thank you for your purchase");
window.open("Checkout.php?total="+price,"_self");
}
else
alert("Add to cart");
}

function auctionnotif(statut)
{
if(statut==1)
alert("Your bet have been accept");
else
alert("Your bet haven't been accept");

}
