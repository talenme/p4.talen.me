<h1><?=APP_NAME?> Review Words</h1>

<select id="catdropdown">
    <?php foreach($categories as $c): ?>
        	<option value="<?=$c['category_id']?>"><?=$c['category_name']?></option>
    <?php endforeach; ?>
</select>

<button>Next</button>

<!-- Ajax results will go here -->
    <div id='results'></div>