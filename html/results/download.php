<?php
$linkstart = "https://www.examinations.ie/exammaterialarchive/?fp=";
function _Download($f_location, $f_name){
  global $linkstart;
  if(substr($f_location, 0, 52) == $linkstart){
    $file = uniqid() . ".pdf";

    file_put_contents($file,file_get_contents($f_location));

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Length: ' . filesize($file));
    header('Content-Disposition: attachment; filename=' . $f_name . ".pdf");

    readfile($file);
    unlink($file);
  }
}

_Download($_GET['file'], $_GET['name']);
