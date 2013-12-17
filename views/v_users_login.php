<?php if(isset($_GET["new_user"])) {echo 
    'You have successfully signed up! Please login with your email 
     address and password.<br><br>';}?>

<form method='POST' action='/users/p_login'>

    <h1><?=APP_NAME?> Login</h1>
    Email<br>
    <input type='text' name='email'>
    <br><br>

    Password<br>
    <input type='password' name='password'>
    <br><br>

    <?php if(isset($error)): ?>
        <div class='error'>
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>

    <input type='submit' value='Log in'>

</form>