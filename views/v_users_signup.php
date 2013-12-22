<form method='POST' action='/users/p_signup'>

    First Name<br>
    <input type='text' name='first_name'>
    <br><br>

    Last Name<br>
    <input type='text' name='last_name'>
    <br><br>

    Email<br>
    <input type='text' name='email'>
    <br><br>

    Password<br>
    <input type='password' name='password'>
    <br><br>


    <input type='submit' value='Sign up'>
    <br><br>

    <?php if (isset($error)): ?>
        <br>
        <div class='error'>
            Login failed!
            <br> <br>
        </div>
        <div class='errorSmall'>
            Due to one or more of the following reasons..
            <br><br>
            - Less Password length (Minimum 3 Characters are required)
            <br>
            - The email you provided is in use already
            <br>
            - Blank fields are not allowed
            <br>
        </div>
        </div>
    <?php endif; ?>

    <!--    --><?php //if($existingEmail == false): ?>
    <!--    <div class='error'>-->
    <!--        Signup failed. You already have an account.-->
    <!--    </div>-->
    <!--    --><?php //endif; ?>
    <br>
</form>