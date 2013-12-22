<br>
<br>

<h1>Create / Delete Categories</h1>
<form method='POST' action='/words/p_category'>
	Name a new word category to add:
    <input type='text' name='category_name' autofocus>
    <input type='submit' value='Submit'>
</form>

<div id="info">
    <br>
    You can click on a category name to review the words belonging to it, and remove any you no longer wish to 
    have in there.<br>
</div>

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
        	<td>
        		<form method="POST" action="/words/cat_details">
        			<input type="submit" value="<?=$cat['category_name']?>" class="unButton" style="background:none;border:0;color:#0080FF">
        			<input type="hidden" name="category_id" value="<?=$cat['category_id']?>">
        			<input type="hidden" name="category_name" value="<?=$cat['category_name']?>">
        		</form>
			</td>
        	<td> <?=$cat['word_count']?> </td>
        	<td> 
        		<form method="POST" action="/words/del_category">
                	<input type="submit" value="Delete" class="edit"> 
                    <input type="hidden" name="category_name" value="<?=$cat['category_name']?>">
                    <input type="hidden" name="user_id" value="<?=$cat['user_id']?>">
                </form> 
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
