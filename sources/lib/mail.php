<?php
namespace myapp;

require_once 'vendor/autoload.php';
require_once 'lib/info.php';


class Mail
{
    private $config = null;
    private $info = null;
 

    public function __construct($config, $info)
    {
        $this->config = $config;
        $this->info = $info;
    }


    private function sendMessage($message)
    {
        // Create the Transport
        $transport = (new \Swift_SmtpTransport(
            $this->config->email_account->SMTP, 
            $this->config->email_account->port,
            $this->config->email_account->encryption))
            ->setUsername($this->config->email_account->username)
            ->setPassword($this->config->email_account->password);

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        return $mailer->send($message);
    }

    public function sendAutomaticResponse($sendToAddress, $msg)
    {
        $message = (new \Swift_Message('Auto response from ' . $this->info->name))
            ->setFrom(array($this->config->email_account->email => $this->config->email_account->emailName))

            // Set the To addresses with an associative array
            ->setTo(array($sendToAddress))

            // And optionally an alternative body
            ->setBody(
                '<p>Hello<br>Your message was sent to the e-mail of ' . $this->info->name .'</p>'.
                '<p>Your original message was:<br>"' . $msg . '"</p>',
                'text/html'
            );

        $this->sendMessage($message);
    }

    public function sendSelfNotification($sendFromAddress, $msg)
    {
        $message = (new \Swift_Message('Message from ' . $sendFromAddress))

            // Set the From address with an associative array
            ->setFrom(array($this->config->email_account->email => $this->config->email_account->emailName))

            // Set the To addresses with an associative array
            ->setTo(array($this->config->email_account->email))

            // And optionally an alternative body
            ->setBody(
                '<p>Hello<br>You have just received a message from someone with the email "' . $sendFromAddress .'"</p>'.
                '<p>His message was:<br>"' . $msg . '"</p>',
                'text/html'
            );
        $this->sendMessage($message);
    }
}
