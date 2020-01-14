<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Print Friend Table</title>
        <meta charset="utf-8">
        <!-- Same styles as printtable.php -->
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
                    $username = $_SESSION['username'];
                    $stmt = $conn->prepare("SELECT B.name, B.username FROM BLCustomerRegistration B ,BLFriends F WHERE (B.username = F.user1 OR B.username = F.user2) AND  (F.user1='" . $username . "' or F.user2='".$username."') AND B.username !='".$username."'");
                    $stmt->execute();
                    $flag = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result= $stmt->fetchAll();

                    if(count($result) == 0){
                        $empty = "Empty";
                        echo "<tr><td>".$empty."</td><td>".$empty."</td><td>".$empty."</td></tr>";
                        $conn = null;
                        exit;
                    }else{
                        //echo "<table>";
                        # ID only exists for legacy purposes. It is not important!
                        //echo "<tr><th>Name</th><th>Username</th>";
                        for($i=0;$i<count($result);$i++){
                            $row = $result[$i];
                            $profile = $row["username"].".php";
                            $link = "<a href=Users/".$profile.">GO To Profile</a>";
                            echo "<tr><td>".$row["name"]."</td><td>".$row["username"]."</td><td>".$link."</td></tr>";
                        }
                        //echo "</table>";
                        $conn = null;
                    }
                }
                # header( "refresh:5;url=member.html" );
                exit;
            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            }
        }
        ?>
    </body>
</html>