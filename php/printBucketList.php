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


                $stmt = $conn->prepare("SELECT username FROM BLCustomerRegistration 
                    where username ='".$_SESSION['username']."'");
                $stmt->execute();
                $flag = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result= $stmt->fetchColumn();

                if(count($result) == 1 ){

                    $stmt = $conn->prepare("SELECT activity,businessName,address,date FROM BLActivities WHERE user_username = '".$result."' ORDER BY date ASC");
                    $stmt->execute();
                    $flag = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result= $stmt->fetchAll();

                    if(count($result) == 0){
                        $empty = "Empty";
                        echo "<tr><td>".$empty."</td><td>";
                        echo $empty."</td><td>".$empty."</td><td>".$empty."</td></tr>";
                        $conn = null;
                        exit;
                    }else{

                        for($i=0;$i<count($result);$i++) {
                            $row = $result[$i];
                            echo "<tr><td>".$row["activity"]."</td><td>";
                            echo $row["businessName"]."</td><td>".$row["address"]."</td><td>".$row["date"]."</td></tr>";
                        }
                    }
                    $conn = null;
                }
                //header("Location: member.html");
                exit;
            } 
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            } 
        }
        ?>
    </body>
</html>