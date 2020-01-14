<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <?php       
        session_start();
        $servername = "localhost";
        if(!isset($_SESSION['username'])){
        ?>
        <script language="javascript" type="text/javascript">
            alert('Message: You need to Sign in.');
            location.replace("../login.html")
        </script>
        <?php
        }
        else{
            $now = time(); // Checking the time now when member page starts.
            if ($now > $_SESSION['expire']) {
                session_destroy();
        ?>
        <script language="javascript" type="text/javascript">
            alert('Message: Your session has expired!. You need to Sign in again.');
            location.replace("../login.html")
        </script>
        <?php
            }
        }
        if($_SESSION['username'] == "guest"){
           header("Location:../member.html");
        }
        if (isset($_SESSION['username'])){
              try {
            $usernameDB = "usernameDB"; 
            $passwordDB ="passwordDB"; 
            $conn = new PDO("mysql:host=$servername;dbname=dbname",trim($usernameDB),trim($passwordDB));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT username FROM BLCustomerRegistration
                    where username ='".$_SESSION['username']."'");
            $stmt->execute();
            $flag = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result= $stmt->fetchColumn();

            if(count($result) == 1 ){

                //var_dump($result);
                //Inserting a record
                 $username = trim($result);
                 $sql = "Insert into BLActivities  (user_username,activity,businessName,address,date) Values ";
                 $sql.= "('$username',";
                 $sql.= "'".$_POST['save_activity']."',";
                 $sql.= "'".$_POST['save_name']."',";
                 $sql.= "'".$_POST['save_address']."',";
                 $sql.= "'".$_POST['date']."')";
                 $conn->exec($sql);
                 $conn = null;
                //echo "New record created successfully.";
                if(isset($_SESSION['username'])){
                    header("Location:../member.html");
                    exit;
                }
                else{
                    header("Location:logout.php");
                    exit;}
            }
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        } 
        }
        ?>
    </body>
</html>