<?php
return array(
    "alma_base_url" => "",          //Details at https://developers.exlibrisgroup.com/alma/apis/
    "alma_api_key" => "",           //Details at https://developers.exlibrisgroup.com/alma/apis/
    "alma_circ_desk" => "",         //Available after logging in at https://developers.exlibrisgroup.com/alma/apis/docs/xsd/rest_item_loan.xsd/?tags=POST
    "alma_library" => "",           //Available after logging in at https://developers.exlibrisgroup.com/alma/apis/docs/xsd/rest_item_loan.xsd/?tags=POST


    "cas_location" => "",           //The location of your CAS.php file.  example: /var/lib/phpCAS/CAS.php
    "bounce_page" => "",            //Where to send the user on failed login

    "cas_server_version" => "",     //Due to loading the config file before loading CAS, we can't use the constant here but must use the value.  For instance, if you're used to entering SAML_version_1_1 you would instead enter "S1".  Values may be checked in CAS.php.
    "cas_server_hostname" => "",
    "cas_server_port" => "",
    "cas_server_uri" => "",
    "cas_server_ca_cert_path" => "",
);