<?php

    namespace App;

    class Helpers
    {
        public static function stringToDate($date)
        {
            $time = strtotime($date);
            $format = date('Y-m-d', $time);

            return $format;
        }
    }
?>
