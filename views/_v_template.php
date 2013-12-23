<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="Description" content="GMP - Inspection Log">
    <title>GMP - Food Safety Inspection Log</title>
    <?php
    define('CSSPATH', '/css/'); //define css path
    $cssItem = 'default.css'; //css item to display
    ?>
    <link rel="stylesheet" href="<?php echo(CSSPATH . "$cssItem"); ?>" type="text/css">
    <!--[if IE]>
    <script src="<?php echo " http://html5shim.googlecode.com/svn/trunk/html5.js"; ?>" </script>
    <![endif]-->
    <?php if (isset($client_files_body)) echo $client_files_body; ?>


    <link rel="stylesheet" href="/scripts/jquery/ui/themes/redmond/jquery.ui.all.css">
    <link type="text/css" rel="stylesheet" href="/css/main.css"/>
    <link href="/scripts/jquery-tableSorter/themes/blue/style.css" type="text/css" rel="stylesheet"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="/scripts/jquery-tableSorter/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="scripts/helperScripts.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="scripts/helperScripts.js"></script>
    <script type="text/javascript" src="/scripts/jquery-tableSorter/jquery.tablesorter.min.js"></script>


</head>

<header>
    <h1><a href='/index.php'> ..Guidelines/Inspection Checklist as per FDA!</a></h1>
    <!--    <h2 class="blog"></h2>-->

    <nav>
        <!-- Welcome Message for the user based on his/her login status -->
        <h3>Welcome</h3>
        <?php if ($user): ?>
            <!-- If the user has already logged in Greet with First Name -->
            <h3 class="userName"><?php echo $user->first_name; ?> !</h3>
        <?php else: ?>
            <!-- If the user has NOT logged in Greet them as 'GUEST!' -->
            <h3 class="userNameGuest">Guest!</h3>
        <?php
        endif; ?>
        <ul>
            <?php if ($user): ?>
                <!-- Menu for users who are logged in -->
                <li><a href='/posts/p_add'>Inspection - Add an Event</a></li>
                <li><a href='/posts/overview'>Deficiency Matrix</a></li>
                <li><a href='/posts/users'>Search Deficiency</a></li>
                <li><a href='/users/logout'>Logout</a></li>
            <?php else: ?>
                <!-- Menu for users who are NOT logged in -->
                <li><a href='/users/signup'>SignUp</a></li>
                <li><a href='/users/login'>Login </a></li>
                <li><a href='/users/forgetpwd'>Forgot Password?</a></li>
            <?php endif; ?>
        </ul>
    </nav>


</header>


<section id="mainContent" class="clear">

    <section id="mainRight">
        <?php if (isset($content)) echo $content; ?>
        <?php if (isset($client_files_body)) echo $client_files_body; ?>
    </section>
    <!-- end mainRight -->
</section>
<footer>
    <!--        Show HTML 5 Validation and footer info-->
    <p>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px"
                 src="http://jigsaw.w3.org/css-validator/images/vcss"
                 alt="Valid CSS!"/>
        </a>
    </p>
    Project 4 - CSCIE15
</footer>
</html>



