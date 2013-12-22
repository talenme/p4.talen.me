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
        	#"/js/jquery.form.js",
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

        # Render template
        echo $this->template;

    }

    public function get_words() {
        
        $cat_id = $_POST['name'];

        $q = "SELECT foreign_word, english_word
                FROM words, cat_word_mapping AS cwm
                WHERE cwm.category_id = '".$cat_id."'
                    AND words.word_id = cwm.word_id";

        # Run the query to get the list of words
        $word_list = DB::instance(DB_NAME)->select_rows($q);

        $counter = 0;
        # count how many words there are in the category
#        foreach ($word_list as $wl)
 #       {
 #           $u = "SELECT *
 #                   FROM cat_word_mapping
 #                   WHERE category_id = '".$wl['category_id']."'";

#            $query_count = DB::instance(DB_NAME)->select_rows($u);

 #           $word_list[$counter]['word_count'] = sizeof($query_count);

  #          $counter++;
   #     }

        echo json_encode($word_list);
    
    }

} # end of the class
