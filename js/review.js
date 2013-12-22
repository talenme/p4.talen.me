/*-------------------------------------------------------------------------------------------------
Greg Misicko December 2013
Logic for the word reviewer
-------------------------------------------------------------------------------------------------*/

var data = new Array();

// used for moving through the word array
var index = 0;
// used for tracking where we are in the view progression, which first shows the foreign word
// and then the definition
var step = 0;
// used to make sure we don't try to access beyond the array index
var limit = 0;

// when the drop down selection is made, this function is triggered
$( "select" ).change(function () {
    $.ajax({
        type: 'POST',
        url: '/review/get_words',
        beforeSend: function() {
        	// reset the index
        	index = 0;
        	step = 0;
            // Display a loading message while waiting for the ajax call to complete
            $('#results').html("Loading...");
        },
        success: function(response) { 
            // get the list of words into our data array
            data = jQuery.parseJSON(response);
  			// useful for debugging....
        	console.log(data);
        	
        	limit = data.length;

    		// careful not to error from empty result sets
    		if (limit)
        	{
        		$('#results').html(data[index]['foreign_word']);
        	}
        	else
        	{
        		$('#results').html("Empty category!");
        	}
        	step++;
        },
        // this is where to specify what data is posted back to server-side php
        data: {
            name: $('#catdropdown').val(),
        },
    }); // end ajax setup

}); 

// what to do when the next button is clicked
$('button').click(function() {
	// make sure we don't get a null pointer. If we've reached the end of the array,
	// time to roll over
	if (limit == index)
	{
		index = 0;
		step = 0;
	}
	// if we are on an odd index, print the full definition
	if (step % 2)
	{
		def = data[index]['foreign_word']+"<br>"+data[index]['english_word'];
		index++;
	}
	// on an even index, only display the foreign word
	else
	{
		def = data[index]['foreign_word'];
	}

	// display the word or words
	document.getElementById('results').innerHTML = def;	
	
	// increment the step tracker
	step++;
});