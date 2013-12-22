<?php
global $user_id;
class users_controller extends base_controller
{
    public function __construct()
    {
        parent:: __construct();
    }

    # no one should see the index page.
    public function index()
    {
        if (!$token) {
            # Send them back to the login page
            Router::redirect("/users/login");
            # But if we did, login succeeded!
        } else {
            Router::redirect("/users/profile");
        }
    }

    public function signupSuccess()
    {
        # Setup view
        $this->template->content = View::instance('v_users_signupSuccess');
        $this->template->title = "Sign Up";
        # Render template
        echo $this->template;
    }

    public function signup()
    {
        # Setup view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title = "Sign Up";
        # Render template
        echo $this->template;
    }

    //  validate field trim & length (empty fields in signup)

    private function checkFieldsFullAndLong()
    {
        #Validate the form
        if (trim($_POST['first_name']) == false) {
            return false;
        } elseif (trim($_POST['last_name']) == false) {
            return false;
        } elseif (trim($_POST['email']) == false) {
            return false;
        } elseif (trim($_POST['password']) == false) {
            return false;
            # If we find the password, Check for the length (minimum 3 characters)
        } elseif (strlen(trim($_POST['password'])) < 3) {
            return false;
        } else {
            // if all is well, we return TRUE
            return TRUE;
        }
    } //checkFieldsFullAndLong

    // Fucntion to check whether email already exists
    private function doesEmailExists()
    {

        //Make sure it's sanitized first
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        // Search the db for this email
//        $q = "SELECT COUNT(*)
//        		FROM users
//        		WHERE email  = '" .$_POST['email']. "'";

        $q = "SELECT COUNT(*)
        		FROM users
        		WHERE email  = '" . $_POST['email'] . "'";

        // Run the query, echo what it returns
        $count = DB::instance(DB_NAME)->select_field($q);
        // If the counter is more than 0
        if ($count > 0) {
            return false;
        } else {
            return true;
        }

    }


    public function p_signup()
    {

        $existingEmail = $this->doesEmailExists();

        if (!$existingEmail || !$this->checkFieldsFullAndLong()) {

            // Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title = "Sign Up";

            // Pass data to the view
            $this->template->content->error = true;

            $this->template->content->existingEmail = $existingEmail;

            // Render template
            echo $this->template;
        } else {

#More data we want stored with the user
            $_POST['DateCreated'] = Time::now();
            $_POST['DateChanged'] = Time::now();

            #Encrypt the password
            $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);

            #Create an encrypted token via their email address and a random string
            $_POST['token'] = sha1(TOKEN_SALT . $_POST['email'] . Utils::generate_random_string());

            # Insert this user into the database
            $user_id = DB::instance(DB_NAME)->insert('users', $_POST);


//        # Prepare the data array to be inserted
//        $data = Array(
//            "created" => Time::now(),
//            "user_id" => $user_id,
//            "user_id_followed" => $user_id
//        );
//
//        # Do the insert
//        DB::instance(DB_NAME)->insert('users_users', $data);
//        # For now, just confirm they've signed up -
//        # You should eventually make a proper View for this
            Router::redirect('/users/signupSuccess');

        }

    }

    public function login($error = NULL)
    {
        # Setup view
        $this->template->content = View::instance('v_users_login');
        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;
    }

    public function p_login()
    {
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token
              FROM users
              WHERE email    = '" . $_POST['email'] . "'
              AND   password = '" . $_POST['password'] . "'";

        $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
        if (!$token) {

            # Send them back to the login page
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
            setcookie("token", $token, strtotime('+1 year'), '/');

            # Send them to the main page - or wherever you want them to go
//            Router::redirect("/");

            # Send them back to the login page
            Router::redirect("/posts/overview");

        }

    }


    public function logout()
    {

        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT . $this->user->email . Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '" . $this->user->token . "'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");

    }

    public function profile()
    {


        # If user is blank, they're not logged in; redirect them to the login page
        if (!$this->user) {
            Router::redirect('/users/login');
        }

        # If they weren't redirected away, continue:
        # Setup view
        $this->template->content = View::instance('v_users_profile');
        $this->template->title = "Profile of" . $this->user->first_name;
        # Render View
        echo $this->template;
    }

    /*
     When the user forgets his password, He or She can use this option
    */

    public function forgetpwd($error = NULL)
    {
        # Setup view
        $this->template->content = View::instance('v_forget_password');
        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;
    }


    public function p_forgetpwd()
    {
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT AuthUserId
              FROM users
              WHERE email = '" . $_POST['email'] . "'";

        $user_id = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
        if (!$user_id) {
            # Send them back to the login page
            Router::redirect("/users/forgetpwd/error");
            # But if we did, login succeeded!
        } else {
            # Send them back to the login page
            $this->template->content = View::instance('v_reset_password');
            $this->template->title = "Reset Password";
            # Pass data (users and connections) to the view
            $this->template->content->userid = $user_id;

            # Render template
            echo $this->template;
            //  Router::redirect("/users/login/reset");

            # Send them to the main page - or wherever you want them to go
            // Router::redirect("/");
        }

    }

    public function p_resetpwd()
    {
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        $update_fields['modified'] = Time::now();
        #Encrypt the password
        $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);
        $update_fields['password'] = $_POST['password'];
        $user_id = $_POST['user_id'];
        # Search the db for this email and password
        # Retrieve the token if it's available
        // Update database straight from the $_POST/$valid_fields array, similar to insert in sign-up
        echo DB::instance(DB_NAME)->update('users', $update_fields, "WHERE user_id =" . $user_id);
        # Tell the user that his/her password has been reset
        $this->template->content = View::instance('v_password_success');
        $this->template->title = " Password";
        # Render template
        echo $this->template;
        //  Router::redirect("/users/login/reset");

        # Send them to the main page - or wherever you want them to go
        // Router::redirect("/");


    }

} #end of class