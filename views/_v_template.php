<!DOCTYPE html>
<html>
<!-- This defines the basic layout for every page in the application -->
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="http://localhost/css/flash_cards.css">	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	

    <div class='menu_holder'>
    	<div class='flag'></div>
    	<div class='menu_title'>---<a href="index.php"><?php echo APP_NAME ?></a></div>
    	<div class='menu_links'>
    		<!-- Top menu for users who are logged in -->
        		<?php if($user): ?>

            		<a href='/users/logout'>Logout</a>&nbsp;&nbsp;|&nbsp;&nbsp;

        	<!-- Top menu options for users who are not logged in -->
        		<?php else: ?>

            		<a href='/users/signup'>Sign up</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            		<a href='/users/login'>Log in</a>

        		<?php endif; ?>
        </div>
    </div>
    
    <br>
    
    <div class='body_content'>
		<?php if(isset($content)) echo $content; ?>
		<?php if(isset($client_files_body)) echo $client_files_body; ?>
	</div>
	
</body>
</html>