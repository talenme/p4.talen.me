


<form method='post' action='/words/p_add'>

    <h1><?=APP_NAME?> Add words to the library</h1>
    There could have been various ways of implementing this, and I chose an approach
    which I think keeps things simple. You can enter a single word with a translation,
    nothing more. The database was designed to support multiple languages, so in the
    future I may change the UI to allow you to select other languages.<br>
    <br>
    Русское слово / Russian word<br>
    <input type='text' name='foreign_word' size='35'>
    <br><br>

    English word / Английское слово<br>
    <input type='text' name='english_word' size='35'>
    <br><br>

    <input type='submit' value='Add word'>

</form>
<br>
<br>

<!-- Ajax results will go here -->
    <div id='results'></div>