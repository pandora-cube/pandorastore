<?php
class Mail {
    private $charset = "UTF-8";
    private $contentType = "text/html";
    private $senderName;
    private $senderAddress;
    private $receiverName;
    private $receiverAddress;
    private $cc;
    private $bcc;
    private $subject;
    private $message;
    
    public function __construct() {
    }

    public function setSender($name, $address) {
        $this->senderName = "=?{$this->charset}?B?".base64_encode($name)."?=";
        $this->senderAddress = $address;
    }

    public function setReceiver($name, $address) {
        $this->receiverName = "=?{$this->charset}?B?".base64_encode($name)."?=";
        $this->receiverAddress = $address;
    }

    public function setCc($cc) {
        $this->cc = $cc;
    }

    public function setBcc($bcc) {
        $this->bcc = $bcc;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function send() {
        if (!isset($this->senderName) || !isset($this->senderAddress)
        || !isset($this->receiverName) || !isset($this->receiverAddress)
        || !isset($this->subject) || !isset($this->message))
            return false;
        
        $header = "Content-Type: {$this->contentType}; charset={$this->charset}\r\n";
        $header .= "From: {$this->senderName} <{$this->senderAddress}>\r\n";
        $header .= "Reply-To: <{$this->senderAddress}>\r\n";
        if (isset($this->cc))
            $header .= "Cc: {$this->cc}\r\n";
        if (isset($this->bcc))
            $header .= "Bcc: {$this->bcc}\r\n";
        
        return mail($this->receiverAddress, $this->subject, $this->message, $header, $this->senderAddress);
    }
}
?>
