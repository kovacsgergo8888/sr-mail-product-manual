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

    private $attachmentNumber = 0;

    public function __construct(Config $config)
    {
        $this->mail = new PHPMailer();
        $this->config = $config;

        if ($config->isSMTP) {
            $this->mail->isSMTP();
            $this->mail->Host = $this->config->Host;
            $this->mail->SMTPAuth = $this->config->SMTPAuth;
            $this->mail->Username = $this->config->Username;
            $this->mail->Password = $this->config->Password;
            $this->mail->SMTPSecure = $this->config->SMTPSecure;
            $this->mail->Port = $this->config->Port;
        } else {
            $this->mail->isMail();
        }
    }

    /**
     * @return int
     */
    public function getAttachmentNumber()
    {
        return $this->attachmentNumber;
    }

    public function getAttachementList()
    {
        return json_encode($this->mail->getAttachments());
    }

    public function getRecepientMail()
    {
        return json_encode($this->mail->getToAddresses());
    }

    /**
     * @param Order $order
     */
    public function prepareMail(Order $order)
    {
        try {
            //Recipients
            $this->mail->setFrom($this->config->fromEmail, $this->config->fromName);
            $this->mail->addAddress($order->getEmail());     // Add a recipient// Name is optional
            //$this->mail->addReplyTo('info@example.com', 'Information');
            if (!empty($this->config->BCCEmail)) {
                $this->mail->addBCC($this->config->BCCEmail);
            }

            //Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $this->config->subject;
            $this->mail->Body = $this->config->getHtmlFileContent();
            $this->mail->AltBody = $this->config->getTextFileContent();

            //manuals
            $this->addAttachments($order->getOrderProducts());

        } catch (PHPMailerException $e) {
            echo "Mail error: " . $this->mail->ErrorInfo;
        }
    }

    /**
     * @param Product[] $products
     */
    protected function addAttachments($products)
    {
        $productManualsDir = __DIR__ . "/../../product_manuals";
        foreach ($products as $product) {
            $file = "$productManualsDir/{$product->getSku()}.pdf";
            if (is_file($file)) {
                $attachName = str_replace("[PRODUCT_NAME]", $product->getName(), $this->config->fileNamePattern);
                try {
                    $this->mail->addAttachment($file, $attachName);
                    $this->attachmentNumber++;
                } catch (PHPMailerException $e) {
                    echo "Error at file-attach: " . $this->mail->ErrorInfo;
                }
            }
        }
    }

    public function send()
    {
        echo $this->attachmentNumber;
        try {
            if ($this->attachmentNumber) {
                $this->mail->send();
            }
        } catch (PHPMailerException $e) {
            echo "Mail error " . $this->mail->ErrorInfo;
        }
    }

}