p4.talen.me
===========

P4 - Final Project
Greg Misicko - December 2013

Background -
I've been studying Russian for the past several years. I can speak and understand it on a basic level, but would not be considered fluent. I hire a language tutor to work with me on reading and grammar. Whenever we work on reading, I have to learn a lot of new vocabulary. When we work on conversation and grammar its the same thing - I have to learn a lot of new words in order to be able to speak on whatever the topic is. I have tried using actual cards for flash cards, but those are very inconvenient. I've tried software flash cards, but never found one that works well. So, I thought it could be useful to me to build my own flash cards tool as a final project. 

How it works -
There are two user types: admin and normal. A normal user can: add words to the library, categorize words, review words. An admin can do the same but also add, delete, and approve (make public) words submitted by non-admin users. Words submitted by non-admin users are visible only to them until an admin reviews and approves them for general availability. This was a security measure to protect users from seeing garbage that malicious users might try to submit. 
You may delete words that you have entered until it becomes 'approved'. Admin users always have the ability to delete words. 

The review page is very plain and simple, this was intentional as I intend to review words mostly from my phone. In the future I plan to add more ways of reviewing words, such as multiple choice games. I also plan to add the ability to upload sound files for words. I know how to do this using the framework, but did not have time to do it. 

I was careful to make sure foreign key deletions were cascaded when necessary.

Enhancements I'll make later:
- Randomize the word order being reviewed
- Add ability to upload sound bytes
- Add sound to the flashcard review
- Make a multiple choice "game" for reviewing words
- Set default categories for new users - settings would be inherited from some super user

Open Bugs / Issues:
If multiple items are selected across various pages of a table, only selected items that are visible will get applied when the 'apply' button is clicked. I would like to try to make it so that you can select items from various pages and apply them all at once.

JavaScript:
- Used in the add word page to make an ajax call for the add. ** I ended up removing the add page when I moved that function to the word 
browser. 
- Used the datatable on various pages.
- Had used a JQuery Accordion for some blocks of info, but removed it because it really didn't look smart.
- Review Words: this is done using JavaScript and Ajax, calling the server to fetch word lists from the database.