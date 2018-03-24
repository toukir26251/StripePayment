<!DOCTYPE html>
<html>
<head>
	<title>Payment</title>
	<script src="https://js.stripe.com/v3/"></script>
</head>
<body>
	<h1>PAYMENT</h1>
	<form action="/payment" method="post" id="payment-form">
		{{csrf_field()}}
	  <div class="form-row">
	    <label for="card-element">
	      Credit or debit card
	    </label>
	    <div id="card-element">
	      <!-- A Stripe Element will be inserted here. -->
	    </div>

	    <!-- Used to display Element errors. -->
	    <div id="card-errors" role="alert"></div>
	  </div>

	  <button>Submit Payment</button>
	</form>

	<script>
		var stripe = Stripe('pk_test_2kQ0fKdDm0fVt5xyEnbFQgaC');
		var elements = stripe.elements();

		// Custom styling can be passed to options when creating an Element.
		var style = {
		  base: {
		    // Add your base input styles here. For example:
		    fontSize: '16px',
		    color: "#32325d",
		  }
		};

		// Create an instance of the card Element.
		var card = elements.create('card', {style: style});

		// Add an instance of the card Element into the `card-element` <div>.
		card.mount('#card-element');

		card.addEventListener('change', function(event) {
		  var displayError = document.getElementById('card-errors');
		  if (event.error) {
		    displayError.textContent = event.error.message;
		  } else {
		    displayError.textContent = '';
		  }
		});

		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
		  event.preventDefault();

		  stripe.createToken(card).then(function(result) {
		    if (result.error) {
		      // Inform the customer that there was an error.
		      var errorElement = document.getElementById('card-errors');
		      errorElement.textContent = result.error.message;
		    } else {
		      // Send the token to your server.
		      stripeTokenHandler(result.token);
		    }
		  });
		});


		function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  		//console.log(token);
		  var form = document.getElementById('payment-form');
		  var hiddenInput = document.createElement('input');
		  hiddenInput.setAttribute('type', 'hidden');
		  hiddenInput.setAttribute('name', 'stripeToken');
		  hiddenInput.setAttribute('value', token.id);
		  form.appendChild(hiddenInput);

		  // Submit the form
		  form.submit();
		}

	</script>

</body>
</html>