<h1><?=APP_NAME?> Review Words</h1>

<select id="catdropdown">
	<option value="-1">*Select Category*</option>
    <?php foreach($categories as $c): ?>
        	<option value="<?=$c['category_id']?>"><?=$c['category_name']?></option>
    <?php endforeach; ?>
</select>

<button>Next</button>
<br>
<br>
<!-- Ajax results will go here -->
    <div id='results' class='results'></div>