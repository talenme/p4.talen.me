<h1><?=APP_NAME?> Manage Words</h1>
    <div class='sectionContainer'>
        <form method='post' action='/words/p_add'>

        <h2> Add words to the library</h2>
        
        <div class='textInputContainer'>
            <div class='inputHolder'>
                Русское слово / Russian word<br>
                <input type='text' name='foreign_word' size='35'>
            </div>
            <div class='inputHolder'>
                English word / Английское слово<br>
                <input type='text' name='english_word' size='35'>
            </div>

            <input type='submit' value='Add word'>
        </div>
        </form>
    </div>
    <br>
    <div class='sectionContainer2'>
        <h2>Add Words to Selected Category</h2>
    

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
to your selected category hit the 'add' button. Word pairs may belong to multiple categories.
<?php endif ?>
    </div>

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
                echo '<th>Delete</th>';
                echo '<th>Approve</th>';
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
                    echo "<td>
                              <input type='checkbox' name='word_to_delete[]' value='".$word['word_id']."'></td><td>";

                      if ($word['approved'] == 0)
                      {
                              echo" <input type='checkbox' name='word_to_approve[]' value='".$word['word_id']."'>";
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

<br><br>

Why can't you delete any words you want? You are only permitted to delete words that have been added by
you, and are not in use by anyone else. 



