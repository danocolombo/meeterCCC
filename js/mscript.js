(function() {
"use strict";

var state = document.getElementById('cb-active-user');
var activeUser = document.getElementById('cb-active-user');
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('frmPeople-Add').addEventListener('submit', confirmVisit);
	
	var tbComments = document.getElementById('peepNotes');
	
	/* btnEstimate.disabled = true;*/
	
	state.addEventListener('change', function() {
	
		if (state.value === '') {
			tbComments.value = "unchecked";
			/* btnEstimate.disabled = true; */
		} else {
			tbComments.value = "checked";
			/* btnEstimate.disabled = false; */
		}
	
	});
});

function confirmVisit(event){
	event.preventDefault();
	if(activeUser.value === ''){
		alert('not active');
		activeUser.focus();
		
	}else{
		alert('seems to be active');
		activeUser.focus();
	}
}

function estimateTotal(event) {
	event.preventDefault();
	
	if (state.value === '') {
		alert('Please choose your shipping state.');
		
		state.focus();
	}
	
	var itemBball = parseInt(document.getElementById('txt-q-bball').value, 10) || 0,
		itemJersey = parseInt(document.getElementById('txt-q-jersey').value, 10) || 0,
		itemPower = parseInt(document.getElementById('txt-q-power').value, 10) || 0,
		shippingState = state.value,
		shippingMethod = document.querySelector('[name=r_method]:checked').value || "";
		
	var totalQty = itemBball + itemJersey + itemPower,
		shippingCostPer,
		shippingCost,
		taxFactor = 1,
		estimate,
		totalItemPrice = (90 * itemBball) + (25 * itemJersey) + (30 * itemPower);
	
	if (shippingState === 'CA') {
		taxFactor = 1.075;
	}
	
	switch(shippingMethod) {
		case 'usps' :
			shippingCostPer = 2;
			break;
		case 'ups' :
			shippingCostPer = 3;
			break;
		default :
			shippingCostPer = 0;
			break;
	}
	
	shippingCost = shippingCostPer * totalQty;
		
	estimate = '$' + ((totalItemPrice * taxFactor) + shippingCost).toFixed(2);
	
	document.getElementById('txt-estimate').value = estimate;
	
	var results = document.getElementById('results');
	
	results.innerHTML = 'Total items: ' + totalQty + '<br>';
	results.innerHTML += 'Total shipping: $' + shippingCost.toFixed(2) + '<br>';
	results.innerHTML += 'Tax: ' + ((taxFactor - 1) * 100).toFixed(2) + '% (' + shippingState + ')';
}

})();