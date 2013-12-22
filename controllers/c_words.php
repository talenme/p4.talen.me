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
        $_POST['modified'] = Time::now();

        # For now this is hard coded. In the future it could be changed to be configurable.
        $_POST['foreign_lang'] = "Russian";

        # if this user is an admin the word is automatically 'approved'
        if ($this->user->admin_flag)
        {
            $_POST['approved'] = "1";
        }

 #       $view = View::instance('v_words_p_add');

        # Check to see if either the foreign or the English word already exists in the db
        $q = "SELECT foreign_word 
            FROM words 
            WHERE foreign_word = '".$_POST['foreign_word']."'";
        $u = "SELECT english_word 
            FROM words 
            WHERE english_word = '".$_POST['english_word']."'";

        $foreignCheck = DB::instance(DB_NAME)->select_field($q);
        $englishCheck = DB::instance(DB_NAME)->select_field($u);
        # If both words exist in db, show one type of warning message
        if ($foreignCheck && $englishCheck)
        { 
            $view->color = "red";
            $view->message = "This word pair already exists in the database";
        }
        # If one of the words exists in the db, show a different message
        elseif ($foreignCheck || $englishCheck)
        {
        	$view->color = "red";
        	if ($foreignCheck)
        	{
        		$view->message = "The foreign entry already exists. Redundant entries are not
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
        	
        	$view->message = "Word pair added sucessfully";
        }
#        echo $view;
        Router::redirect("/words/browse");

    }

    public function browse() {
    	# Set up the view
    	$this->template->content = View::instance('v_words_browse');
    	$this->template->title = APP_NAME.": Words";

        $message = "";

    	$client_files_head = Array(
        	"/js/jquery.dataTables.js",
        	"/js/table_starter.js",
    	);

    	$this->template->client_files_head = Utils::load_client_files($client_files_head);

        # if the user has submitted a request to add words to category...
        if (isset($_POST['word_id_selected']))
        {
            $cat = $_POST['catdropdown'];

            foreach ($_POST['word_id_selected'] as $sel)
            {
                $r = "SELECT *
                        FROM cat_word_mapping
                        WHERE word_id = '".$sel."'
                        AND category_id = '".$cat."'";

                if (!DB::instance(DB_NAME)->select_rows($r))
                {
                    $y = "SELECT english_word
                            FROM words
                            WHERE word_id = '".$sel."'";

                    $a = "SELECT category_name
                            FROM categories
                            WHERE category_id ='".$cat."'";

                    $word_name = DB::instance(DB_NAME)->select_field($y);
                    $cate_name = DB::instance(DB_NAME)->select_field($a);

                    # build the array of values to insert
                    $values['category_id'] = $cat;
                    $values['word_id'] = $sel;
                    $values['created'] = Time::now();
                    # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
                    DB::instance(DB_NAME)->insert('cat_word_mapping', $values);
                    $message .= "added ".$word_name." to ".$cate_name."; ";
                }
            }
        }

        # if the user has submitted a request to delete words...
        if (isset($_POST['word_to_delete']))
        {
            foreach ($_POST['word_to_delete'] as $sel)
            {
                $y = "SELECT english_word
                            FROM words
                            WHERE word_id = '".$sel."'";

                $word_name = DB::instance(DB_NAME)->select_field($y);
                            
                # Delete this connection
                $where_condition = "WHERE word_id = '".$sel."'";  
                DB::instance(DB_NAME)->delete('words', $where_condition); 
                $message .= "deleted ".$word_name."; ";
            }
        }

        # if the user has submitted a request to approve words...
        if (isset($_POST['word_to_approve']))
        {
            foreach ($_POST['word_to_approve'] as $sel)
            {
                $y = "UPDATE words 
                        SET approved = '1' 
                        WHERE words.word_id = '".$sel."'";

                $a = "SELECT english_word
                            FROM words
                            WHERE word_id = '".$sel."'";

                $word_name = DB::instance(DB_NAME)->select_field($a);
                            
                # approve this word
                DB::instance(DB_NAME)->query($y);
                $message .= "approved ".$word_name."; ";
            }
        }

    	# Build the query
    	# if this user is an admin
    	if ($this->user->admin_flag)
    	{
    		$q = 'SELECT words .* ,
    				 users.first_name,
    				 users.last_name
    			  FROM words
    			  INNER JOIN users
    				ON words.user_id = users.user_id';
    	}
    	else
    	{
    		$q = 'SELECT words .* ,
    				 users.first_name,
    				 users.last_name
    			  FROM words
    			  INNER JOIN users
    				ON words.user_id = users.user_id
    			  WHERE words.approved = "1"
    			  	OR words.user_id = "'.$this->user->user_id.'"';
    	}

    	# Run the query to get the list of words
        $word_list = DB::instance(DB_NAME)->select_rows($q);

        $counter = 0;

        # get and add category names associated with each word
        foreach ($word_list as $wl)
        {
            $u = 'SELECT category_name
                    FROM categories, cat_word_mapping
                    WHERE cat_word_mapping.word_id="'.$wl['word_id'].'" 
                    AND categories.category_id = cat_word_mapping.category_id
                    AND categories.user_id = "'.$this->user->user_id.'"';

            $items = DB::instance(DB_NAME)->select_rows($u);

            if ($items)
            {
                $prev='';
                foreach ($items as $i)
                {
                    $word_list[$counter]['cats'] = $prev.'&nbsp;&nbsp;&nbsp;'.$i['category_name'];
                    $prev = $word_list[$counter]['cats'];
                }
                
            }
            else
            {
                $word_list[$counter]['cats'] = "";
            }

            # also identify if this word can be deleted by non-admin user
            if (($wl['approved'] == 0) && ($wl['user_id'] == $this->user->user_id))
            {
                $word_list[$counter]['deleteable'] = "1";
            }
            else
            {
                $word_list[$counter]['deleteable'] = "0";
            }

            $counter++;

        }
        # now get the category list for this user
        $e = 'SELECT category_name, category_id
                FROM categories
                WHERE categories.user_id = "'.$this->user->user_id.'"';

        $category_list = DB::instance(DB_NAME)->select_rows($e);

        # Pass data to the View
        $this->template->content->words = $word_list;
        $this->template->content->categories = $category_list;
        $this->template->content->message = $message;

    	# Render template
        echo $this->template;
    }

    public function category() {
        # Setup view
        $this->template->content = View::instance('v_words_category');
        $this->template->title   = APP_NAME.": Add Category";

        # Load JS files
        $client_files_body = Array(
            "/js/jquery.dataTables.js",
            "/js/table_starter.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);

        $q = "SELECT *
            FROM categories
            WHERE user_id = '".$this->user->user_id."'";

        # Run the query
        $items = DB::instance(DB_NAME)->select_rows($q);
        
        $counter = 0;

        foreach ($items as $i)
        {
            $u = "SELECT *
                    FROM cat_word_mapping
                    WHERE category_id = '".$i['category_id']."'";

            $query_count = DB::instance(DB_NAME)->select_rows($u);

            $items[$counter]['word_count'] = sizeof($query_count);

            $counter++;
        }

        $this->template->content->cats = $items;

        # Render template
        echo $this->template;
    }


    public function p_category() {
        # Associate this word entry with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();

        #$view = View::instance('v_words_category');
    
        # Check to see if this category already exists for this user
        $q = "SELECT category_name
            FROM categories
            WHERE category_name = '".$_POST['category_name']."' AND user_id = '".$this->user->user_id."'";

        $catCheck = DB::instance(DB_NAME)->select_field($q);

        if ($catCheck)
        {
         #   $view->message = "You already have that category in your list!";
         #   $view->color = "red";
        }
        else
        {
            # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
            DB::instance(DB_NAME)->insert('categories', $_POST);

           # $view->message = "Category added!";
           # $view->color = "black";
        }
        Router::redirect("/words/category");

    }    

    public function del_category() {
        # Associate this word entry with this user
        $_POST['user_id']  = $this->user->user_id;

        $q = "DELETE FROM categories
            WHERE category_name = '".$_POST['category_name']."' 
            AND user_id = '".$_POST['user_id']."'";

        # Run the command
        echo DB::instance(DB_NAME)->query($q);
       
        Router::redirect("/words/category");

    }        

    public function cat_details() {
        # Setup view
        $this->template->content = View::instance('v_cat_details');
        $this->template->title   = APP_NAME.": Category Details";

        $this->template->content->category_name = $_POST['category_name'];
        $this->template->content->message = "";

        # Load JS files
        $client_files_body = Array(
            "/js/jquery.dataTables.js",
            "/js/table_starter.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);

        $q = 'SELECT * 
                  FROM words AS w, cat_word_mapping AS cwm
                  WHERE cwm.category_id = "'.$_POST['category_id'].'"
                    AND w.word_id = cwm.word_id';

        # Run the query
        $this->template->content->cat_words = DB::instance(DB_NAME)->select_rows($q);

        # Render template
        echo $this->template;
    }

    public function del_mapping() {
        $this->template->content = View::instance('v_cat_details');
        $this->template->title   = APP_NAME.": Category Details";
        $this->template->content->category_name = $_POST['catg'];
        $this->template->content->category_id = $_POST['category_id'];

        $this->template->content->message = $_POST['words']." removed from the ".$_POST['catg']." category.";
        # Load JS files
        $client_files_body = Array(
            "/js/jquery.dataTables.js",
            "/js/table_starter.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);

        $q = "DELETE FROM cat_word_mapping
            WHERE word_id = '".$_POST['word_id']."'
            AND category_id = '".$_POST['category_id']."'";

        # Run the command
        DB::instance(DB_NAME)->query($q);

        $u = 'SELECT * 
                  FROM words AS w, cat_word_mapping AS cwm
                  WHERE cwm.category_id = "'.$_POST['category_id'].'"
                    AND w.word_id = cwm.word_id';

        # Run the query
        $this->template->content->cat_words = DB::instance(DB_NAME)->select_rows($u);            
       
        echo $this->template;

    } 

} # end of the class