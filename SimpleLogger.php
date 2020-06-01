<?php

class SimpleLogger
{
    public static function appendToLog($type, $message)
    {
        file_put_contents("selfcheck.log", "[". date('Y-m-d h:i:s'). "]<$type>\t$message\n\r", FILE_APPEND);
    }
}