# store_ex
This shopping cart is based off the <a href="http://learninglaravel.net/create-an-e-commerce-website-with-laravel/link"> learninglaravel.net </a> "Create an E-Commerce Website with laravel 5.2" series. 
I made some modifications like bug fixes, Stripe payment intergation, add and remove quantity to shopping cart, and among other things

To get this working, edit your .env file with database fields, and set your app_key by running php artisan key:generate

Then you will have to set your Stripe keys. To get the keys, register an account with stripe, go to your dashboard, under Account Settings,
go to API keys, and if your running a test enviroment choose the test keys

Go to resources/views/cart.blade.php and insert your publishable key in the bottom.

Then go to app/Http/Controllers/OrderController.php and set your secret key in the postOrder() function

Then you should be ready to go!

Modified By <a href="http://changvillage.com/portfolio/">David trushkov</a>
