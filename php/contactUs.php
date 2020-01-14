<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <?php
        session_start();
        if(isset($_POST['inputName']) && isset($_POST['email'])){
            $field_name = $_POST['inputName'];
            $field_email = $_POST['email'];
            $field_phoneNumber = $_POST['phoneNumber'];
            $field_serviceArea = $_POST['serviceArea'];
            $field_message = $_POST['message'];

            $mail_to = 'email@gmail.com';
            $subject = 'Message from Get-Together Bucket List User '.$field_name;

            $body_message = 'From: '.$field_name."\n";
            $body_message .= 'E-mail: '.$field_email."\n";
            $body_message .= 'Phone Number: '.$field_phoneNumber."\n";
            $body_message .= 'Service Area: '.$field_serviceArea."\n";
            $body_message .= 'Message: '.$field_message;

            $headers = 'From: '.$field_email."\r\n";
            $headers .= 'Reply-To: '.$field_email."\r\n";

            $mail_status = mail($mail_to, $subject, $body_message, $headers);
        }



        if(!isset($_SESSION['username'])){

            if ($mail_status) { ?>
        <script language="javascript" type="text/javascript">
            alert('Thank you for the message. We will contact you shortly.');
            location.replace("../index.html");
        </script>
        <?php
            }
            else { ?>
        <script language="javascript" type="text/javascript">
            alert('Message failed. Please, send the email again.');
            location.replace("../contactUs.html")
        </script>
        <?php
            }

        }else{
            if ($mail_status) { ?>
        <script language="javascript" type="text/javascript">
            alert('Thank you for the message. We will contact you shortly.');
            location.replace("../member.html");
        </script>
        <?php
            }
            else { ?>
        <script language="javascript" type="text/javascript">
            alert('Message failed. Please, send the email again.');
            location.replace("../memberContactUs.html")
        </script>
        <?php
            }
        }
        ?>
    </body>
</html>