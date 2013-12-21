<h1><?=$category_name?></h1>
<?=$message?>
<div id="dt_example">
    <div id="container">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="word_table">
    <thead>
        <tr>
            <th>Foreign Word</th>
            <th>English Word</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach($cat_words as $cat): ?>
        <tr>
        	<td> <?=$cat['foreign_word']?> </td>
        	<td> <?=$cat['english_word']?> </td>
        	<td> 
        		<form method="post" action="/words/del_mapping">
                    <input type="hidden" name="word_id" value="<?=$cat['word_id']?>"/>
                    <input type="hidden" name="catg" value="<?=$category_name?>"/>
                    <input type="hidden" name="category_id" value="<?=$cat['category_id']?>"/>
                    <input type="hidden" name="words" value="<?=$cat['foreign_word']?>/<?=$cat['english_word']?>"/>
                    <input type="submit" value="Remove" class="edit"/> 
                </form> 
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>