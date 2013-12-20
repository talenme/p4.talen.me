<br>
<br>

<h1>Create / Delete Categories</h1>
<form method='POST' action='/words/p_category'>
	Name a new word category to add:
    <input type='text' name='category_name'>
    <input type='submit' value='Submit'>
</form>

<div id="dt_example">
    <div id="container">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="word_table">
    <thead>
        <tr>
            <th>Category</th>
            <th># of Words</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach($cats as $cat): ?>
        <tr>
        	<td><?=$cat['category_name']?></td>
        	<td> <?=$cat['word_count']?> </td>
        	<td> 
        		<form method="POST" action="/words/del_category">
                	<input type="submit" value="Delete" class="edit"> 
                    <input type="hidden" name="category_name" value="<?=$cat['category_name']?>">
                </form> 
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
