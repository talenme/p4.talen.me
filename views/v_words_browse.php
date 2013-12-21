<h1>Manage Words</h1>


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




Categories help you group similar words together. This allows you to build 'stacks' of 
flash cards that you can pull up for your studies. It is allowable to add the same word
to multiple categories, so for example you could add 'cat' to the category 'animals'
and also to the category 'nature' - it is up to you how you want to manage your library.
<br><br>

<?php if (!$categories) {echo '<div class="error">Oops! You have not created any categories yet - click 
    <a href="/words/category">here</a> to get started</div>';}; ?>


<?php if ($categories): ?>
First select the category you want to add words to:
<form method="POST" action="/words/browse">
    <select name="catdropdown">
        <?php foreach($categories as $c): ?>
            <option value="<?=$c['category_id']?>"><?=$c['category_name']?></option>
        <?php endforeach; ?>
    </select>
    <br>
Next, select words from the listing below. When you are ready to add the selected words
to your selected category hit the 'add' button.
<?php endif ?>


<div id="dt_example">
    <div id="container">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="word_table">
    <thead>
        <tr>
            <?php if ($categories): ?>
                <th>Select</th>
            <?php endif ?>
            <th>Categories</th>
            <th>Russian Word</th>
            <th>English Word</th>
            <th>Created By</th>
            <?php if($user->admin_flag) 
            {
                echo '<th>Approved</th>'; 
                echo '<th>Actions</th>';
            }
            ?>

        </tr>
    </thead>
    <tbody>
        <?php foreach($words as $word): ?>
            <tr>
                <?php if ($categories): ?>
                    <td><input type="checkbox" name="word_id_selected[]" value=<?=$word['word_id']?>></td>
                <?php endif ?>
                <td><?=$word['cats']?></td>
                <td><?=$word['foreign_word']?></td>
                <td><?=$word['english_word']?></td>
                <td><?=$word['first_name']?> <?=$word['last_name']?></td>
                <?php if($user->admin_flag) 
                {
                    if ($word['approved'] == 0)
                    {
                        echo '<td>NO</td>'; 
                    }
                    else
                    {
                        echo '<td>YES</td>';
                    }
                    echo '<td>
                              <input type="submit" value="Delete" class="edit">';

                      if ($word['approved'] == 0)
                      {
                              echo' <input type="submit" value="Approve" class="edit">';
                      }
                    echo '</td>';
                }
                ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
</div>

<?php if ($categories): ?>
<input type="submit" value="Add Words">

</form>
<?php endif ?>

</div>
