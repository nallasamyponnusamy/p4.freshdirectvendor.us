<?php
global $dbName;
global $dbAdminInfo;

$dbAdminInfo = "pnallasamy@freshdirect.com";

$config = array(

//Database Connections
//"db_host" => "nyc1fdrt02.nyc1.freshdirect.com",
//"db_user" => "fd_fsl_user",
//"db_password" => "zn7zK9Bg",
//"db_database" => $dbName,

    "db_host" => "localhost",
<<<<<<< HEAD
    "db_user" => "freshdir_p4",
    "db_password" => "fresh123",
=======
    "db_user" => "root",
    "db_password" => "",
>>>>>>> 9ba83f1c5631819adc2bb7b28871bb0791a100f0
//    "db_database" => $dbName,
    "db_database" => $dbName,

    "dev" => false, //true=don't send emails, print to screen, false=don't print to screen, send emails

//Admin Stuff
    "site_name" => 'Food Safety Log',
    "admin_email" => "pnallasamy@freshdirect.com"
);
?>