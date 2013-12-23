<?php
global $dbName;
global $dbAdminInfo;

$dbAdminInfo = "pnallasamy@freshdirect.com";

$config = array(


    "db_host" => "localhost",

    "db_user" => "freshdir_p4",
    "db_password" => "fresh123",

//    "db_user" => "root",
//    "db_password" => "",

//    "db_database" => $dbName,
    "db_database" => $dbName,

    "dev" => false, //true=don't send emails, print to screen, false=don't print to screen, send emails

//Admin Stuff
    "site_name" => 'Food Safety Log',
    "admin_email" => "pnallasamy@freshdirect.com"
);
?>