<?php
    header("Access-Control-Allow-Origin: *");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once './vendor/autoload.php';

    use FormGuide\Handlx\FormHandler;

    $pp = new FormHandler(); 

    $validator = $pp->getValidator();
    $validator->field('email')->isEmail();
    $validator->field('message')->maxLength(6000);

    $_mailto = $_GET['email'];
    echo $_mailto;
    $_shuttle = $_GET['shuttle'];
    if($_shuttle == "Shuttle-Yes" ){
        $_shuttle = "Yes";
    }
    if($_shuttle == "Shuttle-No" ){
        $_shuttle = "No";
    }

    echo $_mailto;

    $pp->sendEmailTo($_mailto); // ← Your email here

    $mailer = $pp->getMailer();


    $mailer->IsSMTP();
    $mailer->CharSet = 'UTF-8';

    $mailer->Host       = "mail.amyplusmatt.com"; // SMTP server example
    $mailer->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mailer->SMTPAuth   = true;                  // enable SMTP authentication
    $mailer->Port       = 465;                    // set the SMTP port for the GMAIL server
    $mailer->Username   = "matt@amyplusmatt.com"; // SMTP account username example
    $mailer->Password   = "zsFS5yB:CA"; 


    $mailer->addAddress($_mailto);
    $mailer->addBCC('matt@amyplusmatt.com');
    $mailer->setFrom('matt@amyplusmatt.com','Amy and Matt',false);
    $mailer->isHTML(true);
    $mailer->Subject = 'RSVP Confirmation';
    $mailer->Body    = '<h2 style="margin-bottom:20px">Thank you for your RSVP!</h2>
                        <h3>To confirm, your responses are listed as follows:</h3><br>
                        <b>Attending: </b>'.$_GET['attending']
                        .'<br><b>Guest Names: </b>'.$_GET['names']
                        .'<br><b>Allergies: </b>'.$_GET['allergies']
                        .'<br><b>Riding the shuttle: </b>'.$_shuttle
                        .'<br><b>Number of shuttle seats: </b>'.$_GET['seats']
                        .'<br><b>Shuttle Pick-up Location: </b>'.$_GET['pickup']
                        .'<br><b>Song requests: </b>'.$_GET['songs']
                        ."<br><br>For more information, check our website as the wedding date approaches.
                        <br><br><a href='https://amyplusmatt.com' target='_blank'>amyplusmatt.com</a>
                        <br><br>Amy and Matt";
    $mailer->AltBody = 'Thank you for your RSVP!';
    $mailer->send();
?>