<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <?php 
        session_start();
        $servername = "localhost";
        $db = mysqli_connect($servername,"my_user","my_password","my_db");

        function checkInput($firstName,$lastName,$username,$password,$email){
            if ($firstName != "" && $lastName != "" && $username != "" && $password != "" && $email != "" ){
                return true;
            }
            else{
                throw new Exception("All fields are required!");
            }
        }

        try {
            if(isset($_POST["register"])){ 

                //Removes special characters and all whitespace, validates input, and flattens string to prevent SQL inejection
                //Name
                if (!preg_match("/^[a-zA-Z]*$/", $_POST['registerFirst']) || !preg_match("/^[a-zA-Z]*$/", $_POST['registerLast'])){
                    $_SESSION['Error'] = "Name must only be letters without whitespaces.";
                    $_SESSION['WrongInput'] = 'First Name:'.$_POST['registerFirst'].' Last Name:'. $_POST['registerLast'];
                    header("Location: register.php");
                }
                else{
                    $first = mysqli_real_escape_string($db, preg_replace('/[^a-zA-Z0-9]/', '', $_POST['registerFirst']));                               
                    $last = mysqli_real_escape_string($db, preg_replace('/[^a-zA-Z0-9]/', '', $_POST['registerLast']));  

                    if (strlen($first) > 20 || strlen($last) > 20){
                        $_SESSION['Error'] = "First name and Last name must be less than 20 characters.";
                        $_SESSION['WrongInput'] = "Frist Name:" .$first.' Last Name:'.$last;
                        header("Location: register.php");
                    }
                    $name = $first . ' ' . $last;
                }
                //Username
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST['registerUserName'])){
                    $_SESSION['Error'] = "Username must not have special characters or whitespaces";
                    $_SESSION['WrongInput'] = "Username:" .$_POST['registerUserName'];
                    header("Location: register.php");
                }
                else{
                    $username = mysqli_real_escape_string($db, preg_replace('/[^a-zA-Z0-9]/', '', $_POST['registerUserName'])); 

                    if (strlen($username) > 15){
                        $_SESSION['Error'] = "Username must be less than 15 characters.";
                        $_SESSION['WrongInput'] = "Username:" .$username;
                        header("Location: register.php");
                    }
                }
                //Email
                if (!filter_var($_POST['registerEmail'], FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['Error'] = "Email address not valid.";
                    $_SESSION['WrongInput'] = "Email:" .$_POST['registerEmail'];
                    header("Location: register.php");
                }
                $email = mysqli_real_escape_string($db, preg_replace('/\s+/', '', $_POST['registerEmail']));         
                $password = mysqli_real_escape_string($db, preg_replace('/\s+/', '', $_POST['registerPassword'])); 

                if (strlen($password) < 8 || strlen($password) > 12 ){
                    $_SESSION['Error'] = "Password must be between 8 and 12 characters";
                    $_SESSION['WrongInput'] = $password;
                    header("Location: register.php");
                }
                if (!preg_match("#[0-9]+#", $password)) {
                    $_SESSION['Error'] = "Password must include at least one number!";
                    $_SESSION['WrongInput'] = $password;
                    header("Location: register.php");
                }

                if (!preg_match("#[a-zA-Z]+#", $password)) {
                    $_SESSION['Error'] = "Password must include at least one letter!";
                    $_SESSION['WrongInput'] = $password;
                    header("Location: register.php");
                }    

                if(checkInput($first,$last,$username,$password,$email)){
                    //check if user already exists
                    $result = $db->query("SELECT username,email FROM BLCustomerRegistration  WHERE username='$username' OR email='$email' LIMIT 1");
                    //printf("Select returned %d rows.\n", $result->num_rows);
                    $user = mysqli_fetch_assoc($result);
                    //var_dump($user);

                    if(count($user) != NULL){
                        if ($user["username"] === $username){
                            $_SESSION['Error'] = "Message: Username already exits.";
                            $_SESSION['WrongInput'] = "Username:" .$username;
                            header("Location: register.php");
                        }
                        if ($user["email"] === $email) {
                            $_SESSION['Error'] = "Message: Email already exits.";
                            $_SESSION['WrongInput'] = "Email:" .$email;
                            header("Location: register.php");
                        }
                        /* free result set */
                        $result->close();
                    }else{
                        //Encrypting the password
                        $password = md5($password);
                        //Inserting a record
                        $sql = "Insert into BLCustomerRegistration (name,username,email,password) values ";
                        $sql.= "('".$name."',";
                        $sql.= "'".$username."',";
                        $sql.= "'".$email."',";
                        $sql.= "'".$password."')";                  

                        $result = mysqli_query($db, $sql);
                        mysqli_close($db);
                        $original_file = "../Users/profile.php";
                        $new_file = "../Users/".$username.".php";

                        if(!copy($original_file,$new_file)){
                            $_SESSION['Error'] = "File not created";
                            header("Location: register.html");
                        }
                        header("Location: ../login.html"); 
                        exit;
                    }
                }
            }
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
        ?>
    </body>
</html>