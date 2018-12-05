/* JavaScript Document */
/* after all the HTML on a page is loaded, the following funciton will execute.
$(document).ready(function(){
	alert('this is working');
	//loadCrown();
});

function loadCrown(){
	//this function will load the content for the div "crown" in the header of each page.
	$('#crown').load('content/meeter_content_large.txt');
}


