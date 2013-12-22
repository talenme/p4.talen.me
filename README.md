p4.talen.me
===========

P4 - Final Project
Greg Misicko - December 2013

Background -
I've been studying Russian for the past several years. I can speak and understand it on a basic level, but would not be considered fluent. I hire a language tutor to work with me on reading and grammar. Whenever we work on reading, I have to learn a lot of new vocabulary. When we work on conversation and grammar its the same thing - I have to learn a lot of new words in order to be able to speak on whatever the topic is. I have tried using actual cards for flash cards, but those are very inconvenient. I've tried software flash cards, but never found one that works well. So, this is actually a VERY useful tool for me. 

Features -
- Admin and Regular users: Admin users have more ability to manage the words. They may 'approve' publicly submitted words for viewing by all users, words that are not approved are only viewable by the user who created them. Admin may also delete any words, regular users can only delete
words they have created and are not yet 'approved'.
NOTE: To test the admin feature you can use login: talenme@pyrian.com   pwd: temppass
- Review Words: What I really wanted was a way to flip through words I am studying, and not have to write them out on index cards any more. This feature does that for me. It is small and easy to use from my phone, which is perfect for me.
- Categorize Words: I usually put together sets of woods based on what I am studying. For example if I am reading a story for my lessons, I like to put together a pack of flash cards for that story. Categories are defined by the user, and there is a many to many relationship between categories and words. From the categories page you can create/delete categories, view the words in each category, remove words from categories.
- Add Words: This is where you can enter new word pairs, and then add those words to a category. Words can be deleted by you if you are an admin, or if you are the creator of a word and no one else is already using it (it has not been 'approved' by an admin).

I was careful to make sure foreign key deletions were cascaded when necessary.

Enhancements I'll make later -
- Randomize the word order being reviewed
- Add ability to upload sound bytes
- Add sound to the flashcard review
- Make a multiple choice "game" for reviewing words
- Set some default categories for new users - settings would be inherited from some super user
- Will make user login settings editable (email address, name, pwd)
- Will add email verification step

Open Bugs / Issues -
If multiple items are selected across various pages of a table, only selected items that are visible will get applied when the 'apply' button is clicked. I would like to try to make it so that you can select items from various pages and apply them all at once.

JavaScript -
- Used in the add word page to make an ajax call for the add. ** I ended up removing the add page when I moved that function to the word 
browser. 
- Used the datatable on various pages (datatables.net) .
- Had used a JQuery Accordion for some blocks of info, but removed it because it didn't look good.
- Review Words: this is done using JavaScript and Ajax, calling the server to fetch word lists from the database.