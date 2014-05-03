<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../router.php";

// obtain params from post
$stripeToken = $_POST['stripeToken'];
$customer_email = $_POST['customer_email'];
$user_email = $_POST['user_email'];
$amount = $_POST['amount'];

// Charge the customer's credit card
require_once ('../lib/Stripe/Stripe.php');
Stripe::setApiKey("sk_test_xCTtSZAffzCkUolsHhBvZUrQ");
$token = $stripeToken;
try {
	$charge = Stripe_Charge::create(array(
			"amount" => $amount * 100,
			"currency" => "usd",
			"card" => $token,
			"description" => $customer_email
	));
} catch ( Stripe_CardError $e ) {
	print_r($e); exit;
	// error message
	// @TODO send an alert to our emails
	
	die('Lo sentimos mucho, pero ha habido un error cobrando. Su tarjeta de credito no ha sido cargada. Por favor presione "Atras" en su navegador e intente nuevamente. Si no funciona, escribanos a soporte@apretaste.com y le ayudaremos al momento.');
}

// send confirmation email to the customer

Apretaste::sendEmail(array(
	"answer_type" => "recharge_thankyou",
	"amount" => $amount,
	"user_email" => $user_email,
	"customer_email" => $customer_email
));

// send alert email to the user

Apretaste::sendEmail(array(
	"answer_type" => "recharge_successfull",
	"amount" => $amount,
	"customer_email" => $customer_email
));


// Add the funds to the user
ApretasteMoney::recharge($user_email, $amount);

// redirect to the thank you page
header("thank_you.php?user=$user_email&customer=$customer_email&amount=$amount");
