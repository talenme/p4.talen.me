<h1><?php if($user) echo 'Logged in as '.$user->first_name.' '.$user->last_name; ?></h1>

<?php if($user->admin_flag) echo '<div class=\'error\'>You are working in <b>ADMIN</b> mode</div>'; ?><br>

<br>
	With this application you can add pairs of words to be used in flash card reviews.
	In this version I am only focused on supporting a single language for study (Russian)
	but may extend it to support multiple languages in the future.
	<br>
	<br>
	In addition to adding words pairs for study, you may create categories of word types
	so that you can focus on specific sets of words when you study. Categories are whatever
	you want to define them to be - nouns, verbs, etc - colors, furniture, etc - its up to
	you.
	<br>
	<br>
	After you have created a category and added words to it, you may use that category for
	reviewing words.<br>
<br>
Options:<br>
- Review Words<br>
- <a href="/words/add">Add new words</a><br>
- <a href="/words/category">Add and remove Categories</a><br>
- <a href="/words/browse">Browse word library</a> (and add words to Categories)<br>
+ timed quizes

