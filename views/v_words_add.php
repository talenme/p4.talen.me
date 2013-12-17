<?php if(isset($_GET["code"])) {echo 
    'Your post was successfully posted.<br><br>';}?>

<form method='POST' action='/words/w_add'>

    <h1><?=APP_NAME?> Add words to the library</h1>
    There could have been various ways of implementing this, and I chose an approach
    which I think keeps things simple. You can enter a single word with a translation,
    nothing more.<br>
    <br>
    Русское слово / Russian word<br>
    <input type='text' name='russian_word' size='35'>
    <br><br>

    English word / Английское слово<br>
    <input type='text' name='english_word' size='35'>
    <br><br>

    <?php if(isset($new_word)): ?>
        Done!!!!!
        <br>
    <?php endif; ?>    
    

    <?php if(isset($error)): ?>
        <div class='error'>
            The word you tried to enter already exists in the database. I realize
            there could be multiple definitions for the same word, but to avoid 
            complications with the quizes I will only currently allow one definition
            to exist.<br>
        </div>
        <br>
    <?php endif; ?>    

    <input type='submit' value='Add word'>

</form>