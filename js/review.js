/*-------------------------------------------------------------------------------------------------
Greg Misicko December 2013
Support for Flash Cards app
-------------------------------------------------------------------------------------------------*/

var data;

// when the drop down selection is made, this function is triggered
$( "select" ).change(function () {
    $.ajax({
        type: 'POST',
        url: '/review/get_words',
        beforeSend: function() {
            // Display a loading message while waiting for the ajax call to complete
            $('#results').html("Loading...");
        },
        success: function(response) { 
                // Load the results we get back from process.php into the results div
            //$('#results').html(response);
            data = jQuery.parseJSON(response);
        	console.log(data);
        	if (data[0]['foreign_word'])
        	{
        		$('#results').html(data[0]['foreign_word']);
        	}
        	else
        	{
        		$('#results').html("Empty category!");
        	}
        },
        // this is where to specify what data is posted back to server-side php
        data: {
            name: $('#catdropdown').val(),
        },
    }); // end ajax setup

}); 

$('button').click(function() {
	
	document.getElementById('results').innerHTML = data[0]['english_word'];
	});