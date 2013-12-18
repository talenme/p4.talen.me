<?php
class words_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("You must be logged in to add words to the database. <a href='/users/login'>Login</a>");
        }
    }

    public function add($error = NULL) {
    	# Setup view
        $this->template->content = View::instance('v_words_add');
        $this->template->title   = APP_NAME.": Add Word";

        $this->template->content->error = $error;
        # Load JS files
    	$client_files_body = Array(
        	"/js/jquery.form.js",
        	"/js/words_add.js"
    	);

    	$this->template->client_files_body = Utils::load_client_files($client_files_body);

        # Render template
        echo $this->template;

    }

    public function p_add() {

        # Associate this word entry with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        #$_POST['modified'] = Time::now();

        $view = View::instance('v_words_p_add');

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
        if ($russianCheck && $englishCheck)
        { 
            $view->color = "red";
            $view->message = "This word pair already exists in the database";
        }
        # If one of the words exists in the db, show a different message
        elseif ($russianCheck || $englishCheck)
        {
        	$view->color = "red";
        	if ($russianCheck)
        	{
        		$view->message = "The Russian entry already exists. Redundant entries are not
        			permitted.";
        	}
        	else
        	{
        		$view->message = "The English entry already exists. Redundant entries are not
        			permitted.";
        	}
        }
        # Else we are good to enter this pair into the db
        else
        {
        	# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        	DB::instance(DB_NAME)->insert('words', $_POST);
        	#$this->template->content->error = 2;
        	#Router::redirect("/words/add/error");
        	$view->message = "Word pair added sucessfully";
        }
        echo $view;

    }

    public function browse() {
    	# Set up the view
    	$this->template->content = View::instance('v_words_browse');
    	$this->template->title = APP_NAME.": Words";

    	$client_files_head = Array(
        	"/js/jquery.dataTables.js",
        	"/js/table_starter.js"
    	);

    	$this->template->client_files_head = Utils::load_client_files($client_files_head);

    	# Build the query
    	$q = 'SELECT words .* ,
    				 users.first_name,
    				 users.last_name
    			FROM words
    			INNER JOIN users
    				ON words.user_id = users.user_id';

    	# Run the query
        $word_list = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->words = $word_list;

    	# Render template
        echo $this->template;
    }


} # end of the class