<?php
class words_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("You must be logged in to add words to the database. <a href='/users/login'>Login</a>");
        }
    }

    public function add($error = NULL, $new_word = NULL) {
    	# Setup view
        $this->template->content = View::instance('v_words_add');
        $this->template->title   = APP_NAME.": Add Word";

        # Pass data to the view
        $this->template->content->error = $error;
        $this->template->content->new_word = $new_word;

        # Render template
        echo $this->template;

    }

    public function w_add() {

        # Associate this word entry with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        #$_POST['modified'] = Time::now();

        # Check to see if either the Russian or the English word already exists in the db
        $q = "SELECT russian_word 
            FROM words 
            WHERE russian_word = '".$_POST['russian_word']."'";
        $u = "SELECT english_word 
            FROM words 
            WHERE english_word = '".$_POST['english_word']."'";

        $russianCheck = DB::instance(DB_NAME)->select_field($q);
        $englishCheck = DB::instance(DB_NAME)->select_field($u);
        # If both words exist in db, show one type of warning message
        if ($russianCheck && englishCheck)
        { 
            Router::redirect("/words/add/error");
        }
        # If one of the words exists in the db, show a different message
        elseif ($russianCheck || $englishCheck)
        {
        	Router::redirect("/words/add/error");
        }
        # Else we are good to enter this pair into the db
        else
        {
        	# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        	DB::instance(DB_NAME)->insert('words', $_POST);
        	#$this->template->content->error = NULL;
        	Router::redirect("/words/add?code=2");
        }


        # If one or more does already exist, send them to the edit page for that entry

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        #DB::instance(DB_NAME)->insert('posts', $_POST);

        # Quick and dirty feedback
        #Router::redirect("/posts/add?submitted=1");

    }

    public function index() {
    	# Set up the view
    	$this->template->content = View::instance('v_words_index');
    	$this->template->title = APP_NAME.": Words";
    }


} # end of the class