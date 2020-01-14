<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <?php  
        session_start();
        $servername = "localhost";
        $db = mysqli_connect("localhost","my_user","my_password","my_db");
        try {
            $username = trim($_POST['loginName']);
            $password = md5(trim($_POST['loginPassword']));

            //check if user already exists
            $result = $db->query("SELECT username,password FROM BLCustomerRegistration  WHERE username='$username' AND password='$password' LIMIT 1");
            //printf("Select returned %d rows.\n", $result->num_rows);

            $user = mysqli_fetch_assoc($result);
            //var_dump($user);

            if(count($user) != NULL){
                
                $_SESSION['username'] = $username; //Store username to session for futher authorization 
                $_SESSION['start'] = time(); // Taking now logged in time.
                // Ending a session in 60 minutes from the starting time.
                $_SESSION['expire'] = $_SESSION['start'] + (60 * 60);

                header("Location: ../member.html"); //Redirect user to member page

                mysqli_close($db);
                /* free result set */
                $result->close();
                exit;
            }else{ ?>
        <script language="javascript" type="text/javascript">
            alert('Message: Invalid username or password.');
            history.back(1);
        </script>
        <?php
            }
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        } 
        ?>
    </body>
</html>
