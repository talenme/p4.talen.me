/*-------------------------------------------------------------------------------------------------
Greg Misicko December 2013
Support for Flash Cards app
-------------------------------------------------------------------------------------------------*/

// Set up the options for ajax
var options = { 
    type: 'POST',
    url: '/words/p_add/',
    beforeSubmit: function() {
    	console.log("here");
        $('#results').html("Adding...");
    },
    success: function(response) {   
    	console.log("and here");
        $('#results').html(response);
    } 
}; 

// Using the above options, ajax'ify the form
$('form').ajaxForm(options);