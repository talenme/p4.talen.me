
<br>
From here you can browse the table of words.         
<br>
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
        </tr>
    </thead>
    <tbody>
        <?php foreach($words as $word): ?>
            <tr>
                <td><?=Time::display($word['created'])?></td>
                <td><?=$word['russian_word']?></td>
                <td><?=$word['english_word']?></td>
                <td><?=$word['first_name']?> <?=$word['last_name']?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>