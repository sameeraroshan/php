<?php


namespace Serato\Common;


trait ValidityChecker
{

    /** check whether given string is a valid one.
     * @param $string
     * @return bool
     */
    public function isValidJson(string $string): bool
    {    //todo check for more invalid scenarios.
        return is_object(json_decode($string)) || is_array(json_decode($string));
    }

    /** empty body is considered as invalid.
     * @param $formData
     * @return bool
     */
    public function isValidForm($formData): bool
    {  //todo check for more invalid scenarios.
        return !empty($formData);
    }
}