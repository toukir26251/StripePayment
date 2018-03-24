<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
	public function payment()
	{
		\Stripe\Stripe::setApiKey("sk_test_0Y1fzfdeDuAJowwDf3Pdy05k");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
		$token = $_POST['stripeToken'];

		// Charge the user's card:
		$charge = \Stripe\Charge::create(array(
		  "amount" => 1000000,
		  "currency" => "usd",
		  "description" => "Example charge",
		  "source" => $token,
		));
	}   
}
