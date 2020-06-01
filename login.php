<?php
$configs = include("config.php");
require_once $configs["cas_location"];     // CAS Authentication

phpCAS::client($configs["cas_server_version"], $configs["cas_server_hostname"], $configs["cas_server_port"], $configs["cas_server_uri"]);
if (empty($configs["cas_server_ca_cert_path"]))
{
    phpCAS::setNoCasServerValidation();
}
else
{
    phpCAS::setCasServerCACert($configs["cas_server_ca_cert_path"]);
}


phpCAS::forceAuthentication();
//IMPORTANT!  Any other implementation will still need to return the ALMA id as $user_id
$user_id = phpCAS::getUser();

if (isset($_POST['logout']))
{
    phpCAS::logout();
}

if (!$user_id){ // forward to index page again.
    header( 'Location: ' . $configs["bounce_page"] ) ;
    exit;
}

