
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <?php       
        session_start();
        $servername = "localhost";
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
                $activity = $_SESSION['activity'];
                $businessName = $_SESSION['businessName'];
                $address = $_SESSION['address'];
                $date = $_SESSION['date'];
                
                unset($_SESSION['activity']);
                unset($_SESSION['businessName']);
                unset($_SESSION['address']);
                unset($_SESSION['date']);
               // echo $activity;
               // echo $businessName;
               // echo $address;
               // echo $date;

               $sql = "Insert into BLActivities  (user_username,activity,businessName,address,date) Values ";
                $sql.= "('$result',";
                $sql.= "'".$activity."',";
                $sql.= "'".$businessName."',";
                $sql.= "'".$address."',";
                $sql.= "'".$date."')";

                $conn->exec($sql);
                $conn = null;

                if(isset($_SESSION['username'])){
                    header("Location:../member.html");
                    exit;
                }
                else{
                    header("Location:logout.php");
                    exit;
                }
            }
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        } 
        ?>
    </body>
</html>
