<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.20.
 * Time: 16:05
 */

namespace ProductManualMailer;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception AS PHPMailerException;

class Mailer
{
    /**
     * @var PHPMailer $mail
     */
    private $mail;

    /**
     * @var Config $config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->mail = new PHPMailer();
        try {
            //Server settings

            if ($config->isSMTP) {

                $this->mail->isSMTP();                                      // Set mailer to use SMTP
                $this->mail->SMTPDebug = 2;                                 // Enable verbose debug output
                $this->mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
                $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
                $this->mail->Username = 'user@example.com';                 // SMTP username
                $this->mail->Password = 'secret';                           // SMTP password
                $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $this->mail->Port = 587;                                    // TCP port to connect to
            } else {
                $this->mail->isMail();
            }

        } catch (PHPMailerException $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
        }
    }

    public function prepareMail($_POST)
    {
        try {
            //Recipients
            $this->mail->setFrom('from@example.com', 'Mailer');
            $this->mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $this->mail->addAddress('ellen@example.com');               // Name is optional
            $this->mail->addReplyTo('info@example.com', 'Information');
            $this->mail->addCC('cc@example.com');
            $this->mail->addBCC('bcc@example.com');

            //Attachments
            $this->mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = 'Here is the subject';
            $this->mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        } catch (PHPMailerException $e) {
            echo "Mail error: " . $this->mail->ErrorInfo;
        }
    }

    public function send()
    {
        try {
            $this->mail->send();
        } catch (PHPMailerException $e) {
            echo "Mail error " . $this->mail->ErrorInfo;
        }
    }

}