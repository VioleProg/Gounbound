<?php
echo "<div align=\"center\">";
if ($_GET['act'] == "check") {
    $email = $_POST['email'];
    $forgetpwd = mysql_query("SELECT * FROM `user` WHERE E_Mail = '$email'", $sql);
    while ($fpwdinfo = mysql_fetch_array($forgetpwd)) {
    if ($fpwdinfo['E_Mail'] == $email) {
        $body = "Hello you have requested for user and password\n";
        $body .= "----------------------------------------------\n";
        $body .= " ";
        $body .= "User: ".$fpwdinfo['user'];
        $body .= "Password: ".$fpwdinfo['password'];
        $body .= "\n";
        $body .= "----------------------------------------------\n";
        $body .= "\n";
        $body .= "Thanks the Administration of ".$servername."\n";
    }else{
        echo "The email ".$email." is not cadastred with an account.";
    }
    }
}else{
    echo "Put here your account email to verify and send to you a email with you password<br /><br />"
    ."<form action=\"forgot_pass.html\" method=\"POST\">"
    ."<table border=\"0\">"
    ."<tr>"
    ."<td>E-mail:</td>"
    ."<td><input class=\"post\" name=\"email\" type=\"text\" size=\"20\"></td>"
    ."</tr>"
    ."<tr>"
    ."<td colspan=\"2\"><div align=\"center\"><input class=\"mainoption\" type=\"submit\" value=\"Check\"></div></td>"
    ."</tr>"
    ."</table>"
    ."</form>";
}
echo "</div>";
?>