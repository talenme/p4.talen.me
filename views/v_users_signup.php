<form method='POST' action='/users/p_signup'>

    <h1><?=APP_NAME?> Signup</h1>
    Please enter all fields to create an account. Creating an account will allow you to submit
    words for consideration (submitted words must be approved before they will be available).<br>
    <br>
    First Name<br>
    <input type='text' name='first_name'>
    <br><br>

    Last Name<br>
    <input type='text' name='last_name'>
    <br><br>

    Email<br>
    <input type='text' name='email'>
    <br><br>

    Password<br>
    <input type='password' name='password'>
    <br><br>

    <?php if(isset($error)): ?>
        <div class='error'>
            All fields are required - please re-check your input to ensure<br>
            all fields are entered and email address is valid.<br>
            Email address must be unique.<br>
        </div>
        <br>
    <?php endif; ?>    

    <input type='submit' value='Sign up'>

</form>