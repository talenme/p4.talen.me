/*-------------------------------------------------------------------------------------------------
Greg Misicko December 2013
Support for Flash Cards app
-------------------------------------------------------------------------------------------------*/

// handles the click event, sends the query
var options = { 
    type: 'POST',
    url: '/words/p_category/',
    	beforeSubmit: function() {
        	//$('#results').html("Adding...");
    	},
    	success: function(response) {   
        	$('#results').html(response);
    	} 
}; 

// Using the above options, ajax'ify the form
$('form').ajaxForm(options);