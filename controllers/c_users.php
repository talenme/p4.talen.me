<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function signup($error = NULL) 
    {

        # Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = APP_NAME.": Create New User";

        # Pass data to the view
            $this->template->content->error = $error;

        # Render template
            echo $this->template;
    }

    public function p_signup() 
    {
        # Dump out the results of POST to see what the form submitted
         print_r($_POST);

        # More data we want stored with the user
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now(); 

        if((!$_POST['first_name']) || (!$_POST['last_name']) || 
            (!$_POST['password']) || (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) 
        {
            # Send them back to the login page with an error message
            Router::redirect("/users/signup/error");
        }

        # Ensure that the email address entered does not already exist
        $q = "SELECT email 
            FROM users 
            WHERE email = '".$_POST['email']."'";

        $emailCheck = DB::instance(DB_NAME)->select_field($q);
        # If it does, don't allow them to proceed
        if ($emailCheck)
        { 
            Router::redirect("/users/signup/error");
        }

        # Encrypt the password  
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());                

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # Send them home
        Router::redirect("/users/login?new_user=1");
   
    }    

    public function login($error = NULL) {
        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = APP_NAME.": Login";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;        
    }

    public function p_login() {

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token 
            FROM users 
            WHERE email = '".$_POST['email']."' 
            AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
        if(!$token) {

            # Send them back to the login page with an error message
            Router::redirect("/users/login/error");

        # But if we did, login succeeded! 
        } else {

            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token, strtotime('+2 weeks'), '/');

            # Send them to the main page - or whever you want them to go
            Router::redirect("/");

        }

    }

    public function logout() {
 
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");
    }

    public function profile($user_name = NULL) {

        # If user is blank, they're not logged in; redirect them to the login page
        if(!$this->user) {
            Router::redirect('/users/login');
        }

        # Fetch the bio
        $q = "SELECT about 
            FROM users 
            WHERE user_id = '".$this->user->user_id."'";

        $about = DB::instance(DB_NAME)->select_field($q);

        # Fetch the location
        $q2 = "SELECT location 
            FROM users 
            WHERE user_id = '".$this->user->user_id."'";

        $loc = DB::instance(DB_NAME)->select_field($q2);

        # Setup view
        $this->template->content = View::instance('v_users_profile');
        $this->template->title   = APP_NAME." Profile of ".$this->user->first_name;

        # Pass the bio and location info to the view
        $this->template->content->about = $about;
        $this->template->content->loc = $loc;
        # Render template
        echo $this->template;
    }

    public function p_profile($user_name = NULL) {

        # If user is blank, they're not logged in; redirect them to the login page
        if(!$this->user) {
            Router::redirect('/users/login');
        }
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Do the update
        DB::instance(DB_NAME)->update("users", $_POST, "WHERE user_id = '".$this->user->user_id."'");

        # Redirect back to the profile page
        Router::redirect('/users/profile?submitted=1');
    }


} # end of the class