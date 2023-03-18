<?php 

session_start();

// connect to the database
//  -- usernames are emails
// check for any duplicate usernames in the database
// if there is a duplicate, redirect to login page - maybe?
// if no duplicate, insert the username and password into the database

// After registering, an email is sent to the user with a hyperlink in it. 
// When the user clicks on the hyperlink, the account is activated and yser can log in
// if the user doesn't click on the hyperlink, user cannot access the account

?>