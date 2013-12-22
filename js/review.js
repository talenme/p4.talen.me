/*-------------------------------------------------------------------------------------------------
Greg Misicko December 2013
Support for Flash Cards app
-------------------------------------------------------------------------------------------------*/

var data = new Array();

var index = 0;

// when the drop down selection is made, this function is triggered
$( "select" ).change(function () {
    $.ajax({
        type: 'POST',
        url: '/review/get_words',
        beforeSend: function() {
        	// reset the index
        	index = 0;
            // Display a loading message while waiting for the ajax call to complete
            $('#results').html("Loading...");
        },
        success: function(response) { 
                // Load the results we get back from process.php into the results div
            //$('#results').html(response);
            data = jQuery.parseJSON(response);
      //      data = JSON.parse(response);
  
        	console.log(data);
        	
        	if (data[index]['foreign_word'])
        	{
        		$('#results').html(data[index]['foreign_word']);
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
	// if we are on an odd index, print the full definition
	var def =" ";

	alert(index);
	if (index % 2)
	{
		def = data[index]['foreign_word']+"<br>"+data[index]['english_word'];
	}
	// on an even index, only display the foreign word
	else
	{
		def = data[index]['foreign_word'];
	}
	document.getElementById('results').innerHTML = def;	
	
	index++;
});