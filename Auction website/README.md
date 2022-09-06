# DYNAMICWEB

Zakaria Tozy
Ibraguim Vadouev
Matthieu Sajot

Front-end Ibraguim
Back-end Zakaria Matthieu

## Dynamic Web Programming Project
### Specification:

The project is to create an auction website similar to EBay, Let’s call the website - ‘Yourmarket’. The website should allow the user to buy, bid or trade for an item in the site, to individuals to sell its items on the site and for the site manager to administer the trade site.

In this site, you can find the following menus: Categories, Buying, Sell, Your account, Cart and Admin. The descriptions of these menus is as follows:
- Categories: These are the categories of items for sale. Your website should have at least two categories. Here is where I want you to make a choice. You can choose any two categories of your choice. Your website will be an online marketplace for only that kind of products. For example, each category you choose should be a sector; for example – automobiles, clothing, electronic devices, furniture etc.

- Buying: There are three ways to buy from ‘Yourmarket’: (i) Auctions, (ii) Buy it now, and (iii) Best offer. Here are the instructions for each purchase category:
- Auctions: In the "Auctions" category, an article is displayed for a fixed period (example: from Monday April 19, 2021 at 9:00 a.m. to Friday April 23, 2021 at 4:59 p.m.). People bid on an item and the highest bidder wins. How to bid? Here is the procedure:
- An interested buyer informs ‘Yourmarket’ that they are interested in bidding for a specific item by clicking on the bid button.
-He / She informs the ‘Yourmarket’ administrator of the maximum price he / she is willing to pay for this article. And it remains there! For example, suppose you want to pay $
500 as the maximum bid for an item (example: A Cartier brand ring, 18 karat yellow gold, 4.8 grams).
- ‘Yourmarket’ will do the bidding for you automatically.
- Before the auction period closes, admin reviews the highest bid. If the highest bid at that time is, say $ 400, then ‘Yourmarket’ will bid 401 $ for you. And you win! You pay $ 401 for this item, not $ 500.
- Buy it now: This is a "Buy It Now", no auction takes place. You purchase the item at the stated price and you get it. This is the most convenient way to buy.
- Best Offer: In the “Best Offer” category, you trade electronically, via the ‘Yourmarket’ website, with the seller. You can negotiate up to 5 times to conclude the final price of an article. How to negotiate your best offer?
- You negotiate with the seller. You set the price and wait.
- The seller accepts your offer or offers a counter-offer. If the seller accepts your offer, the process ends.
- The process is repeated 5 times until it is satisfactorily concluded or becomes invalid.
- Note that if you make an offer on an item, you are under a legal contract for buying it if the seller accepts the offer.
- Sell: This is the menu linked with a seller who would like to sell his items to the ‘Yourmarket’.
- Your account: This is the menu linked with the ‘Yourmarket’ buyer/seller.
- Cart: This is a menu linked with the current buyer and the items he/she has chosen to buy.
- Admin: It is linked with the account of the manager of the ‘Yourmarket’.
The objective of this site will therefore be to create an online platform allowing e-commerce sales by auction, which can be found in real life. This exercise will allow you to familiarize yourself with e-commerce, which you can use in the future to sell the products or services. As part of this project, you will develop a front-end platform allowing sell items from admin and sellers, as well as customer purchases. You will also develop the back-end platform that will allow transparent purchasing transactions and sales, the complexity of which is hidden from the e-commerce user.
This exercise will allow students to put into practice all the concepts taken from Dynamic Web, including HTML, CSS, JavaScript, jQuery, PHP, and MySQL. You are also allowed to use other tools to complement the tools and
concepts already learned in this course. It should be noted that the ready-made platforms, such as WordPress, do not allow students to show their proficiency in web programming and this reason and therefore they are prohibited to use for this Project.

### Features:
The site must contain three types of users: buyer, seller, and administrator
1) The Administrator
- An administrator is the sales manager. He can add or delete items in the market site.
- Each item for sale has its identification number, name, one or more photos, its descriptions (quality and defect), its video (if available) and its price. An item for sale is put away in a category: (i) Category 1, (ii) Category 2 – Based on your choice.
- Secondly, an administrator can add or delete sellers (suppliers) with their ‘Yourmarket’ username and name on a database, server side of the site. In the site of market, there are several items for sale thanks to the suppliers who add their items for sale in the site.
2) Sellers
- First, each seller accesses his account with his username and email with verification that they exist
- The seller's site displays their name, photo, and favorite background image on their site wall.
- The site must allow each seller to publish items for sale. Each item for sale has its identification number, name, photo / s, descriptions (quality and default), video (if available), category and price. An item for sale maybe for sale by auction, by best offer or by buy it now.
- No item can be for sale by bid and by best offer at the same time.
- An item for immediate sale has a high price.
- If an item (for example, a jewel) is for immediate sale and for sale by best offer in at the same time, this item is deleted from the site as soon as a sale is concluded, regardless of its purchase category.
- The seller can add or remove items for sale. When a customer buys an item with success, the database linked with this item must be updated accordingly, reflecting the sale.
3) Buyers
- A customer visits the ‘Yourmarket’ site to buy, negotiate, or bid on one or more items. On the ‘Yourmarket’ site, the customer can access the “Your Account” menu. This part identifies a customer by his "Last Name and
First Name", his "Address", his "Email" and his information on payment (hidden discreetly).
- He / She must accept the clause telling the client that if he / she makes an offer on an item, he / she is legally contracted to purchase it if the seller accepts the offer.
- Each customer has own shopping cart, which is displayed on the site with an image of a shopping cart. In this basket, you can find all the items that the customer would like to buy, bid or negotiate.
- Each item in the basket has its photo, a small description of the item and the price. At the end of the list of the items, we can find the total in the chosen currency. Payment is automatic for the category "Best Offer" if a negotiation is concluded.
- Payment is also automatic if the customer is the winner of an auction. For a "Buy It Now", the customer will move to a "Checkout" button. By clicking on the button "Go to order”, the immediate purchase is concluded.
- The ‘Yourmarket’ web page accesses the customer's account. For security reasons, the customer identifies himself by his login (his email) we create a new account suitable for this client.
- When the login and password are all verified (by verifying that this information is stored in the database), the payment site enters its delivery details:
  
- Name and Surname
- Address Line 1
- Address Line 2
- City
- Postal code
- Country and
- Customer's telephone number.
- In the payment part, this information is requested from the customer:
- Type of payment card (Visa, MasterCard, American Express, PayPal)
- Card number
- Name displayed in the map
- Card expiration date and
- Security code (3 or 4 digits, depending on the card).
- In real life, the sales site communicates with the bank or financial institution to approval of a purchase by credit card. In this project, we will simply validate the purchase if we find all this information in our database.
- When a purchase transaction is completed, the site sends an email message to the customer, validating the purchase. In this project, you don't have to do this. However, if you do, you tell the customer the relevant information as well as the approximate date and time
Delivery. You are rewarded with a minimum bonus of 0.5 point and a maximum of 1.5 point, depending on the quality of your work.
1) Advanced / innovative features
- You have flexibility in interpreting some parts of this topic, taking into account what is the best possible e-commerce site. In addition, you are free to add some advanced or innovative features in your site.
- You can put the option of payment by gift certificate provided by ‘Yourmarket’ to its customers as another payment method or as a complement to card payment credit.
- You may also consider some special days, such as “Mother’s Day ", “The Father's Day”, “Christmas”, “Valentine’s Day”, etc. When those days come, your site adapts accordingly by offering products or offers which are apt for the occasion. You can also add discount to the final price (e.g. 10% ~ 20% discount).
- This project is a client-server application. Information related to storage of items for sale, information related to each item, information related to the buyer, the vendor and administrator will all be saved in the server. You will need to set up a database server.
