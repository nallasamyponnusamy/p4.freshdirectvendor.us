<html>
<form method='POST' action='/users/p_forgetpwd'>

    Email<br>
    <input type='text' name='email'>

    <br><br>
    <input type='submit' value='Reset Password'>
    <!--    Wrong email / invalid email error-->
    <br><br>
    <?php if (isset($error)): ?>
        <div class='error'>
            Error!.
        </div>
        <br>
        <div class='errorSmall'>
            The Email you have provided is not valid or you have not registered yet. If you have not registered, please
            signup!.
        </div>
        <br>
    <?php endif; ?>

</form>
</html>