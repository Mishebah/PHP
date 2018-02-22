A few things to note here
First is that our form's action attribute is set to register.php. This means that when the form submit button is clicked, all the data in the form will be submitted to the same page (register.php). The part of the code that receives this form data is written in the server.php file and that's why we are including it at the very top of the register.php file.
Sessions are used to track logged in users and so we include a session_start() at the top of the file.
The if statement determines if the reg_user button on the registration form is clicked. Remember, in our form, the submit button has a name attribute set to reg_user and that is what we are referencing in the if statement.

All the data is received from the form and checked to make sure that the user correctly filled the form. Passwords are also compared to make sure they match.

If no errors were encountered, the user is registered in the users table in the database with a hashed password. The hashed password is for security reasons. It ensures that even if a hacker manages to gain access to your database, they would not be able to read your password.
When a user is registered in the database, they are immediately logged in and redirected to the index.php page.

And that's it for registration
