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

    /**
     * @var PlaceholderTransformer
     */
    private $placeholderTransformer;

    public function __construct(Config $config)
    {
        $this->mail = new PHPMailer();
        $this->config = $config;

        $this->mail->CharSet = "UTF-8";

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
        $this->placeholderTransformer = new PlaceholderTransformer($order);
        try {
            //Recipients
            $this->mail->setFrom($this->config->fromEmail, $this->config->fromName);
            $this->mail->addAddress($order->getEmail());
            if (!empty($this->config->BCCEmail)) {
                $this->mail->addBCC($this->config->BCCEmail);
            }

            $this->mail->isHTML(true);
            $this->mail->Subject = $this->placeholderTransformer->replace($this->config->subject);
            $this->mail->Body = $this->placeholderTransformer->replace($this->config->getHtmlFileContent());
            $this->mail->AltBody = $this->placeholderTransformer->replace($this->config->getTextFileContent());

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
        foreach ($products as $product) {
            if ($product->hasManual()) {
                $attachName = str_replace("[PRODUCT_NAME]", $product->getName(), $this->config->fileNamePattern);
                try {
                    $this->mail->addAttachment($product->getManualFile(), $attachName);
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