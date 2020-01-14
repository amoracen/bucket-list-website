<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
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
            try {
                $usernameDB = "usernameDB"; 
                $passwordDB ="passwordDB"; 
                $conn = new PDO("mysql:host=$servername;dbname=dbname",trim($usernameDB),trim($passwordDB));
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $requester = $_SESSION['username'];

                if($_POST['save_friend']) {                               
                    $requestee = $_POST['save_friend'];

                    //check if user exists
                    $stmt = $conn->prepare("SELECT username FROM BLCustomerRegistration
                        where username ='".$requestee."' LIMIT 1");
                    $stmt->execute();
                    $flag = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $user = $stmt->fetchColumn();;

                    //check if friendship exists
                    $stmt2 = $conn->prepare(
                        "SELECT * FROM BLFriends WHERE user1 = '".$requester."' AND user2 = '".$requestee."' 
                UNION 
                 SELECT * FROM BLFriends WHERE user1 = '".$requestee."' AND user2 = '".$requester."'");
                    $stmt2->execute();
                    $flag2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                    $friendship = $stmt2->fetchColumn();;

                    //if friendship doesn't already exist
                    if(!$friendship) {
                        // if user exists
                        if ($user === $requestee) {
                            //Inserting a record                  
                            $sql = "INSERT INTO BLFriends (user1, user2) VALUES ('$requester', '$requestee')";  
                            $conn->exec($sql);
                            $conn = null;
            ?>
            <script language="javascript" type="text/javascript">
                alert('Message: Friend added to your list.');
                location.replace("../member.html")
            </script>
            <?php
                        }
                        else { 
            ?>
            <script language="javascript" type="text/javascript">
                alert('Message: Could not find your friend.');
                location.replace("../member.html")
            </script>
            <?php
                        }
                    }
                    else {
            ?>
            <script language="javascript" type="text/javascript">
                alert('Message: User is already friends with you.');
                location.replace("../member.html")
            </script>
            <?php
                    }
                }
                else {
                    echo "Oops, there was an error";
                    header( "refresh:1;../member.html" );
                }
            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            }
            catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
            ?>
        </div>
    </body>
</html>