<?php 
session_start();

?>

 <!DOCTYPE html>
 <html>
 <head>
    <title>Dojo Wall - Login</title>
    <link rel='stylesheet' href='main.css'>
 </head>
 <body>

    <div id="container">

        <div id="header">
            <h3><a href='index.php'>CodingDojo Wall</a></h3>
            <p>Welcome to the Wall!</p>  
        </div>

        <div class='errors'>
            <?php 
                if( isset( $_SESSION['errors'])){
                    foreach ( $_SESSION['errors'] as $error ) {
                    echo "<p>$error</p>";
                }
                    unset($_SESSION);
                }
            ?>
        </div>

        <div id='register'>
            <h4>Register:</h4>
            <form action='process.php' method='post'>
                <input type='hidden' name='action' value='register'>
                First Name: <input type='text' name='first_name'>
                Last Name: <input type='text' name='last_name'>
                Email: <input type='email' name='email'>
                Password: <input type='password' name='password'>
                Confirm Password: <input type='password' name='confirm_password'>
                <input type='submit' value='Register'>
            </form>
        </div>

        <div id='login'>
            <h4>Login:</h4>
            <form action='process.php' method='post'>
                <input type='hidden' name='action' value='login'>
                Email: <input type='email' name='email'>
                Password: <input type='password' name='password'>
                <input type='submit' value='Login'>
            </form>
        </div>
    </div>
</body>
</html>