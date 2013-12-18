
<br>
From here you can browse the table of words.         
<br>
<br>
<br>

<?php $i = 0; ?>

<table id="word_table">
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
                <td>guy</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>