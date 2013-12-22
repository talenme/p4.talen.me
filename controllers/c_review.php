<?php
class review_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("You must be logged in to review anything. <a href='/users/login'>Login</a>");
        }
    }

    public function cards() {
    	# Setup view
        $this->template->content = View::instance('v_review');
        $this->template->title   = APP_NAME.": Review";

        # Load JS files
    	$client_files_body = Array(
        	"/js/review.js"
    	);

    	$this->template->client_files_body = Utils::load_client_files($client_files_body);

        # now get the category list for this user
        $e = 'SELECT category_name, category_id
                FROM categories
                WHERE categories.user_id = "'.$this->user->user_id.'"';

        $category_list = DB::instance(DB_NAME)->select_rows($e);

        # Pass data to the View
        $this->template->content->categories = $category_list;

        $this->template->content->size = sizeof($category_list);

        # Render template
        echo $this->template;

    }


    public function get_words() {
        
        $cat_id = $_POST['name'];

        $q = "SELECT w.foreign_word, w.english_word
                FROM words AS w, cat_word_mapping AS cwm
                WHERE cwm.category_id = '".$cat_id."'
                    AND w.word_id = cwm.word_id";

        # Run the query to get the list of words
        $word_list = DB::instance(DB_NAME)->select_rows($q);

        # send the results back in JSON format
        echo json_encode($word_list);
    
    }

} # end of the class
