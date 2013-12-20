p4.talen.me
===========

P4 - Final Project
Greg Misicko - December 2013

Background -
I've been studying Russian for the past several years. I can speak and understand it on a basic level, but would not be considered fluent. I hire a language tutor to work with me on reading and grammar. Whenever we work on reading, I have to learn a lot of new vocabulary. When we work on conversation and grammar its the same thing - I have to learn a lot of new words in order to be able to speak on whatever the topic is. I have tried using actual cards for flash cards, but those are very inconvenient. I've tried software flash cards, but never found one that works well. So, I thought it could be useful to me to build my own flash cards tool as a final project. 

How it works -
There are two user types: admin and normal. A normal user can: add words to the library, categorize words, review words. An admin can do the same but also add, delete, and approve (make public) words submitted by non-admin users. Words submitted by non-admin users are visible only to them until an admin reviews and approves them for general availability. This was a security measure to protect users from seeing garbage that malicious users might try to submit. 

Important - 
There is a difference in functionality between the admin user and a regular user. 
If you enter a new word, you will be able to see it in the browse list and use it immediately. However, other users will NOT be able to see it until it is 'approved' by an admin user. Admin users can see all words. This is a safety measure to prevent idiots from entering incorrect or offensive words and ruining things for other users.

I was careful to make sure foreign key deletions were cascaded when necessary.

Testing constantly was difficult, and as I had to test many things before the code to control them was complete I had to do a lot of manual editing of the database.

JavaScript -
- Used in the add word page to make an ajax call for the add. 
- Used in the browse section to display a Jquery table