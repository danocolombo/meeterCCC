/* meeter.js
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
"use strict";
(function(){
    //Document.getElementById('peepForm').addEventListener('submit', submitButton);

    function checkAllInterests(event){
        alert("in script in the page");
        event.preventDefault();
        //start on the first checkbox
        if(document.getElementById('peepFellowshipTeam').value == checked){
            alert("The Fellowship Team IS selected");
        }else{
            alert("The Fellowship Team is NOT selected");
        }
    }
})();

function SelectAllInterests(){
    //alert("SelectAllInterests called");
    document.getElementById('cbFellowship').checked = true;
    document.getElementById('cbPrayer').checked = true;
	document.getElementById('cbNewcomers').checked = true;
	document.getElementById('cbGreeter').checked = true;
	document.getElementById('cbSpecialEvents').checked = true;
	document.getElementById('cbSResources').checked = true;
	document.getElementById('cbSmallGroup').checked = true;
	document.getElementById('cbStepStudy').checked = true;
	document.getElementById('cbTransportation').checked = true;
	document.getElementById('cbWorship').checked = true;
	document.getElementById('cbYouth').checked = true;
	document.getElementById('cbChildren').checked = true;
	document.getElementById('cbNursery').checked = true;
	document.getElementById('cbCafe').checked = true;
	document.getElementById('cbMeal').checked = true;
	document.getElementById('cbCRIM').checked = true;
	document.getElementById('cbCRIW').checked = true;
	document.getElementById('cbTeaching').checked = true;
	document.getElementById('cbChips').checked = true;
    
    return false;
}
function SelectNoInterests(){
	// this function unchecks all the interests on the people form
	document.getElementById('cbFellowship').checked = false;
    document.getElementById('cbPrayer').checked = false;
	document.getElementById('cbNewcomers').checked = false;
	document.getElementById('cbGreeter').checked = false;
	document.getElementById('cbSpecialEvents').checked = false;
	document.getElementById('cbSResources').checked = false;
	document.getElementById('cbSmallGroup').checked = false;
	document.getElementById('cbStepStudy').checked = false;
	document.getElementById('cbTransportation').checked = false;
	document.getElementById('cbWorship').checked = false;
	document.getElementById('cbYouth').checked = false;
	document.getElementById('cbChildren').checked = false;
	document.getElementById('cbNursery').checked = false;
	document.getElementById('cbCafe').checked = false;
	document.getElementById('cbMeal').checked = false;
	document.getElementById('cbCRIM').checked = false;
	document.getElementById('cbCRIW').checked = false; 
	document.getElementById('cbTeaching').checked = false;
	document.getElementById('cbChips').checked = false;
    return false;
}
