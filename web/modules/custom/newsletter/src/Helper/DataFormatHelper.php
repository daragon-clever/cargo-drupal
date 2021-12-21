<?php

namespace Drupal\newsletter\Helper;

class DataFormatHelper
{
    public static function isMobilePhone($mobilePhone)
    {
        $cleanMobilePhone = str_replace(' ', '', trim($mobilePhone));
        $mobilePhoneLength = strlen((string)$mobilePhone);
        $firstCharacters = substr($cleanMobilePhone, 0, 2);
        $firstCharacters2 = substr($cleanMobilePhone, 0, 4);
        $firstCharacters3 = substr($cleanMobilePhone, 0, 5);

        if (in_array($firstCharacters, ['06', '07']) && $mobilePhoneLength === 10
            || in_array($firstCharacters2, ['+336', '+337']) && $mobilePhoneLength === 12
            || in_array($firstCharacters3, ['+3306', '+3307']) && $mobilePhoneLength === 13) {
            return true;
        }

        return false;
    }
}