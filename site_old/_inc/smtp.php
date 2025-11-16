<?
/*------------------------------------------------------------------------
Copyright: 5ubliminal. Use, alter and distribute freely without
altering the Copyright notice in anyway!
Whenever you refer to this class or publish this / any variation of this
code you will aknowledge copyright and link back to the original
source of this class which is mentioned here:
--
http://www.tellinya.com/read/2008/03/18/326.html
--
Disclaimer: I take no reponsability for anything... blah, blah, blah
------------------------------------------------------------------------*/
class eSmtp{
    //-- SMTP Server to use for delivery!
    var $smtpServer            = "";
    var $smtpPort            = 25;
    //-- Attached files
    var $lstAttachs            = array();
    //-- Recepient list
    var $lstRecipients         = array();
    //-- Headers list
    var $lstHeaders            = array();
    //-- AUTH data for SMTP who need login
    var $authUser            = "";
    var $authPass            = "";
    //-- Reply and From details
    var $replyName            = "";
    var $replyMail            = "";
    var $fromName            = "";
    var $fromMail            = "";
    //-- MIME enabled?
    var $isMimeOn            = 1;
    //-- Debug enabled outputs all sends and receives
    var $isDebug            = 0;
    //-- Enable HTML content in Message Body
    var $isHtml                = 0;
    //-- Message Subject
    var $msgSubject            = "";
    //-- Message Body
    var $msgBody            = "";
    //-- The socket used to do the magic
    var $smtpSocket            = 0;
    //--
    function eSmtp($smtpServer=false,$smtpPort=25){
        //-- Some defines to start with
        define("EOL","\r\n");
        define("MSG_END","\r\n.\r\n");
        define("EOH","\r\n\r\n");
        define("SEP","\r\n--#BOUNDARY#--");
        define("EOM","QUIT\r\n\0");
        //-- We default SMTP server to local host if none given as parameter
        $this->smtpServer    = (($smtpServer!==false) ? $smtpServer : $_SERVER["LOCAL_ADDR"]);
        $this->smtpPort        = $smtpPort;
    }
    //-- Set Message Subject
    function setSubject($msgSubject){
        $this->msgSubject    = $msgSubject;
    }
    //-- Set Message Body
    function setBody($msgBody){
        $this->msgBody        = $msgBody;
    }
    //-- Set From Details
    function setFrom($fromName,$fromMail){
        $this->fromName        = $fromName;
        $this->fromMail        = $fromMail;
    }
    //-- Set Reply-To Details
    function setReplyTo($reply2Name,$reply2Mail){
        $this->replyName    = $reply2Name;
        $this->replyMail    = $reply2Mail;
    }
    //-- Add A New Attachment. You need the path and an internal name
    //-- which can be different from the local file used.
    //-- MIME type will be guessed internally
    function addAttachment($filePath,$fileName){
        $filePath        = str_replace("\\","/",$filePath);
        if(!isset($fileName)){
            $fileName    = substr(strrchr($filePath,'/'),1);
        }
        $fileExtension    = substr(strrchr($fileName,'.'),1);
        $mimeType        = "application/octet-stream";
        if(isset($MimeTypes[$fileExtension]))
            $mimeType=$MimeTypes[$fileExtension];
        return $this->attachFile($filePath,$fileName,$mimeType);
    }
    //-- Same as above but MIME type can be specified
    function attachFile($filePath,$fileName,$mimeType="application/octet-stream"){
        if(!filesize($filePath)) return false;
        $this->lstAttachs[$fileName] = array(
            "Path"    => $filePath,
            "Mime"    => $mimeType
        );
        return true;
    }
    //-- Add recipient: name, mail and type as below
    function addRecipient($recName,$recMail,$recType/*to|cc|bcc*/){
        if(!isset($recType)) $recType="to";
        else $recType=strtolower($recType);
        $recType=strtolower($recType);
        if(!is_array($this->lstRecipients[$recType])){
            $this->lstRecipients[$recType]=array();
        }
        $this->lstRecipients[$recType][$recMail]=$recName;
    }
    //-- Add raw headers (Expert)
    function addHeader($hdrName,$hdrValue){
        $this->lstHeaders[$hdrName]=$hdrValue;
    }
    //-- Set importance, parameter can have below values
    function setImportance($importance/*low|normal|high*/){
        $this->addHeader("X-Importance",$importance);
    }
    //-- Set sensitivity, parameter can have below values
    function setSensitivity($sensitivity/*Personal|Private|Company-Confidential*/){
        $this->addHeader("X-Sensitivity",$sensitivity,"X");
    }
    //-- Set priority, parameter can have below values
    function setPriority($priority/*low|normal|high*/){
        $this->addHeader("X-Priority",$priority);
    }
    //-- Set SMTP server AUTH
    function setAuth($authUser,$authPass){
        $this->authUser    = $authUser;
        $this->authPass    = $authPass;
    }
    //-- Internal function used to output data if debug enabled
    function _debugLine($line,$sent=1){
        $line=trim($line);
        if(!$this->isDebug) return;
        echo nl2br(htmlentities($line)."<br />");
    }
    //-- Internal function used to send data
    function _sendLines($lstLines,$raw=0){
        if($raw){
        }
        if(!is_array($lstLines)){
           $lstLines    = str_replace("\r","",$lstLines);
            $lstLines    = explode("\n",$lstLines);
            if(!count($lstLines)) $lstLines=array($lstLines);
        }
        foreach($lstLines as $line){
            $line = trim($line);
            $this->_debugLine($line);
            if(!fputs($this->smtpSocket,$line."\r\n")){
                return false;
            }
        }
        return true;
    }
    //-- Internal function used to receive replies
    function _getAnswer(){
        $line="";
        while(!feof($this->smtpSocket)){
            $ch    = fgetc($this->smtpSocket);
            if(!strlen($ch)) return false;
            if($ch=="\n"){
                $this->_debugLine($line,0);
               if($line[3]==" ") return (int)substr($line,0,3);
                $line    = ""; continue;
            }
            if($ch!="\r") $line.=$ch;
        }
        return false;
    }
    //-- Internal function used to issue AUTH command
    function _authLogin(){
        $buf="AUTH LOGIN";
        $this->_sendLines($buf);
        if($this->_getAnswer()!=334){
            fclose($this->smtpSocket);
            return false;
        }
        $buf=sprintf("%s",base64_encode($this->authUser));
        $this->_sendLines($buf);
        if($this->_getAnswer()!=334){
            fclose($this->smtpSocket);
            return false;
        }
        $buf=sprintf("%s",base64_encode($this->authPass));
        $this->_sendLines($buf);
        if($this->_getAnswer()!=235){
            fclose($this->smtpSocket);
            return false;
        }
        return true;
    }
    //-- Connect to SMTP server
    function connect($timeout=5){
        $errno        = "";
        $errstr        = "";
        $this->smtpSocket =
            fsockopen ($this->smtpServer, $this->smtpPort,
                $errno, $errstr, $timeout);
        if (!$this->smtpSocket){
            $this->_debugString($errno.":".$errstr."\r\n");
            return false;
        }
        if($this->_getAnswer()!=220){
            fclose($this->smtpSocket);
            return false;
        }
        if(($this->authUser!="") && ($this->authPass!=""))
            $buf=sprintf("EHLO %s","localhost");
        else
            $buf=sprintf("HELO %s","localhost");
        $this->_sendLines($buf);
        $hiReply    = $this->_getAnswer();
        if($hiReply == 250){
            return $this->_authLogin();
        }
        $buf=sprintf("HELO %s","localhost");
        if($this->_getAnswer()!=250){
            fclose($this->smtpSocket);
            return false;
        }
        return true;
    }
    //-- Disconnect from SMTP server
    function disconnect(){
        $this->_sendLines("QUIT");
        $quitReply = $this->_getAnswer();
        fclose($this->smtpSocket);
        if($quitReply==221)
            return true;
        return true;
    }
    //-- Internal function used to write SMTP recipients
    function _sendRecipients(){
        $result        = 0;
        $mails        = array();
        $mailsErr    = array();
        while(list($type,$list)=each($this->lstRecipients)){
            while(list($mail,$name)=each($list)){
                if(in_array($mail,$mails)) continue;
                $buf    =sprintf("RCPT TO:<%s>",$mail);
                $this->_sendLines($buf);
                $rez    =$this->_getAnswer();
                array_push($mails,$mail);
                if($rez==250) continue;
                array_push($mailsErr,$mail);
                unset($this->lstRecipients[$type][$mail]);
            }
        }
        return ((count($mails)-count($mailsErr))>0);
    }
    //-- Internal functions used to send headers
    function _sendHeaders(){
        reset;($this->lstHeaders);
        while(list($name,$value)=each($this->lstHeaders)){
            $buf    ="$name: $value";
            $this->_sendLines($buf);
        }
        reset($this->lstRecipients);
        while(list($type,$list)=each($this->lstRecipients)){
            $mails    = array();
            while(list($mail,$name)=each($list)){
                array_push($mails,"$name <$mail>");
            }
            $type[0]    =strtoupper($type[0]);
            if(isset($this->lstHeaders[$type])) continue;
            $buf        ="$type: ".implode(",",$mails)."";
            $this->_sendLines($buf);
        }
        $buf=sprintf("From: %s <%s>",$this->fromName,$this->fromMail);
        $this->_sendLines($buf);
        if(strlen($this->replyMail)){
            $buf=sprintf("Reply-to: %s <%s>",$this->replyName,$this->replyMail);
            $this->_sendLines($buf);
        }
        $buf=sprintf("Subject: %s",$this->msgSubject);
        $this->_sendLines($buf);
        return true;
    }
    //-- Internal function used to send message body depending on encoding: HTML, Text
    function _sendMessage(){
        if($this->isMimeOn){
            $buf =
                "MIME-Version: 1.0\r\n".
                "Content-type: multipart/mixed; boundary=\"#BOUNDARY#\"\r\n\r\n";
            $this->_sendLines($buf);
            $buf=
                "\r\n--#BOUNDARY#\r\n".
                "Content-Type: text/".($this->isHtml ? "html" : "plain")."; charset=us-ascii\r\n";
            $this->_sendLines($buf);
        }else{
            $buf="\r\n";
            $this->_sendLines($buf);
        }
        $this->_sendLines($this->msgBody,1);
        return true;
    }
    //-- Internal function used to send attachments
    function _sendAttachments(){
        if(!$this->isMimeOn) return true;
        if(!count($this->lstAttachs)) return true;
        while(list($name,$file)=each($this->lstAttachs)){
            $fpath        = $file['Path'];
            $mime        = $file['Mime'];
            $fname        = $this->names[$i];
            $newfile    = fopen($fpath,"rb");
            $content    = fread($newfile, filesize($fpath));
            fclose($newfile);
            $content    = base64_encode($content);
            $buf =
                sprintf("\r\n\r\n--#BOUNDARY#\r\n".
                "Content-Type: ".$mime.";&;nbsp;name=%s\r\n".
                "Content-Length: ".filesize($file)."\r\n".
                "Content-Transfer-Encoding: base64\r\n".
                "Content-Disposition: attachment; filename=%s\r\n".
                "Content-ID: <%s>\r\n\r\n",
                $name,$name,$name);
            $this->_sendLines($buf);
            $this->_sendLines($content,1);
        }
        return true;
    }
    //-- Send function sends email.
    function send($connect=false,$disconnect=false){
        if($connect)
            if(!$this->connect()) return false;
        //--
        $buf=sprintf("MAIL FROM:<%s>",$this->fromMail);
        $this->_sendLines($buf);
        if($this->_getAnswer()!=250){ fclose($this->smtpSocket); return false; }
        if(!$this->_sendRecipients()){ fclose($this->smtpSocket); return false; }
        //--
        $this->_sendLines("DATA");
        if($this->_getAnswer()!=354){ fclose($this->smtpSocket); return false; }
        if(!$this->_sendHeaders()){ fclose($this->smtpSocket); return false; }
        if(!$this->_sendMessage()){ fclose($this->smtpSocket); return false; }
        if(!$this->_sendAttachments()){ fclose($this->smtpSocket); return false; }
        //--
        $this->_sendLines(MSG_END);
        if($this->_getAnswer()!=250){ fclose($this->smtpSocket); return false; }
        if($disconnect){ $this->disconnect(); }
        return true;
    }
    //--
};
//-- Copyright: 5ubliminal
?>