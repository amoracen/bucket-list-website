<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- My styles for the table -->
        <link href="mycss/mystyleTable.css" rel="stylesheet">
    </head>
    <body>
        <?php  
        session_start();
        $servername = "localhost";
        if(!isset($_SESSION['username'])){
            $msg = "You need to Sign in.";
            echo "<tr><td>".$msg."</td><td>";
            echo $msg."</td></tr>";
        }
        else{
            try {
                $usernameDB = "usernameDB"; 
                $passwordDB ="passwordDB"; 
                $conn = new PDO("mysql:host=$servername;dbname=dbname",trim($usernameDB),trim($passwordDB));
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT name,username,email FROM BLCustomerRegistration 
                    where username ='".$_SESSION['username']."'");
                $stmt->execute();
                $flag = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result= $stmt->fetchAll();
                if(count($result) == 0 ){
                    $error = "Error";
                    echo "<tr><td>".$error."</td><td>";
                    echo $error."</td><td>".$error."</td></tr>";
                    $conn = null;
                    exit;
                }
                else{
                    //$row = $result[$i];
                    //var_dump($result);
                    //$type ="../updateProfile.php";
                    //$button = "<a class=\"btn btn-primary\" href=".$type." role=\"button\">Save</a>";
                    echo "<tr><td>".$result[0]["name"]."</td><td>";
                    echo $result[0]["username"]."</td><td>".$result[0]["email"]."</td></tr>";
                    $conn = null;
                }
                exit;
            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            } 
        }
        ?>
    </body>
</html>