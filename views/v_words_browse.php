
<br>
Categories help you group similar words together.          

<br>
<br>

<?php $i = 0; ?>

<div id="dt_example">
    <div id="container">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="word_table">
    <thead>
        <tr>
            <th>Created</th>
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
                <td><?=Time::display($word['created'])?></td>
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
                    echo '<td><input type="submit" value="Edit" class="edit">
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
</div>