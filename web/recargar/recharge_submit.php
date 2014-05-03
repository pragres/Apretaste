<?php

include "../router.php";

// obtain params from post
$stripeToken = $_POST['stripeToken'];
$customer_email = $_POST['customer_email'];
$user_email = $_POST['user_email'];
$amount = $_POST['amount'];

// Charge the credit card
Stripe::setApiKey("sk_test_xCTtSZAffzCkUolsHhBvZUrQ");
$token = $stripeToken;
try {
	$charge = Stripe_Charge::create(array(
		"amount" => 1000, // amount in cents, again
		"currency" => "usd",
		"card" => $token,
		"description" => "payinguser@example.com")
	);
} catch(Stripe_CardError $e) {
	// error message
	// @TODO send an alert to our emails
	die('Lo sentimos mucho, pero ha habido un error cobrando. Su tarjeta de credito no ha sido cargada. Por favor presione "Atras" en su navegador e intente nuevamente. Si no funciona, escribanos a soporte@apretaste.com y le ayudaremos al momento.');
}

// send confirmation emails


// Add the funds to the user

// create payment log


// redirect to the thank you page
header("thank_you.php?user=$user_email&customer=$customer_email&amount=$amount");