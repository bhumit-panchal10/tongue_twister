<?php
// dd('hello');
$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/mailers/contactemail.html', 'r');
//$file = file_get_contents("https://getdemo.in/mas_solutions/mailers/welcome-company.html", "r");
$file = str_replace('#name', $data['name'], $file);
$file = str_replace('#email', $data['email'], $file);
$file = str_replace('#mobile', $data['mobileNumber'], $file);
$file = str_replace('#message', $data['message'], $file);
echo $file;

?>
