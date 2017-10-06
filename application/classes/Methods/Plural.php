<?php

class Methods_Plural
{

    public static function getWithPlural($number, $key) {
        $format = array(
            'events'    => array('мероприятие','мероприятия','мероприятий'),
        );

        $forms = $format[$key];
        return $number % 10 == 1 && $number % 100 != 11 ? $forms[0] : ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20) ? $forms[1] : $forms[2]);
    }

}
