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
Categories help you group similar words together. This allows you to build 'stacks' of 
flash cards that you can pull up for your studies. It is allowable to add the same word
to multiple categories, so for example you could add 'cat' to the category 'animals'
and also to the category 'nature' - it is up to you how you want to manage your library.
<br><br>

<div class='sectionContainer'>
Options:<br>
- <a href="/review/cards">Review Words</a><br>
- <a href="/words/category">Categories</a>: Add and remove Categories, view the contents
of categories, remove words from categories<br>
- <a href="/words/browse">Words</a>: Add words to the library, add words to the categories
you've defined<br>
</div>


