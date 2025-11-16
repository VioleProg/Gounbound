<?php

function writelog($logentry, $lgname) {
global $config;
$user = @isset($_SESSION["s_usuario"]) ? $_SESSION["s_usuario"] : '' ;
$logentry = $_SERVER['REMOTE_ADDR']. " ". @$_SERVER['PHP_AUTH_USER']." $logentry";
$lgname = 'a.txt';
      $logfile = @fopen ($lgname, "a+");
      if (!$logfile)
        {
          echo (" ERROR: Failed to open $lgname");
        }
      else
        {
          fwrite ($logfile, "[".date ("D M d Y h:iA")."] [$logentry]\r\n");
          fclose ($logfile);
        }
}


writelog("erro no banco de dados...",  $_SESSION["s_usuario"]);
?>