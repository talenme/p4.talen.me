<h1><?=APP_NAME?> Review Words</h1>

<select id="catdropdown">
	<option value="-1">*Select Category*</option>

    <?php foreach($categories as $c): ?>
        	<option value="<?=$c['category_id']?>"><?=$c['category_name']?></option>
    <?php endforeach; ?>


</select>

<button>Next</button>
<br>
<?php if ($size == 0) echo('Go create some <a href="/words/category/">categories</a>!');?>
<br>
<!-- Ajax results will go here -->
    <div id='results' class='results'></div>