<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <?php  
        session_start();
        // remove all session variables
        session_unset();
        //echo "Successfully Log out";
        header( "refresh:0;url=../login.html" );
        exit;
        ?>

    </body>
</html>