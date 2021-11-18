<?php
$linkstart = "https://www.examinations.ie/exammaterialarchive/?fp=";
$linkstart2 = "https://archive.maths.nuim.ie/staff/dmalone/StateExamPapers/";
function _Download($f_location, $f_name){
  global $linkstart;
  global $linkstart2;
  if(substr($f_location, 0, 52) == $linkstart | substr($f_location, 0, 60) == $linkstart2){
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
