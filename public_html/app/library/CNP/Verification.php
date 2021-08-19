<?php
/*****************************************************************************
* library/CNP.php
*
* Author: David Gabriel
*
*****************************************************************************/

namespace Tripsy\Library\CNP;

class Verification extends \Tripsy\Library\Error
{
    /**
     * @var string value to verify.
     */
    private $string;

    /**
     * Used to calculate control digit.
     */
    private const CONTROL_NUMBER = 279146358279;

    /**
     * @param string $string
     */
    public function __construct(string $string) {

        $this->string = trim($string);
    }

    /**
     * Format verification for cnp string
     *
     * @return string
     */
    public function validateFormat() : string {
        return $this->is_empty($this->string, 'empty_string')
                    ->is_length($this->string, 13, 13, 'invalid_length')
                    ->is_number($this->string, 'invalid_chars')
                    ->is_true($this->checkControlDigit($this->string) === false, 'control_number_fail');
    }

    /**
     * Extra verification for data consistency
     *
     * @param \Tripsy\Library\CNP\Data $cnp_data
     *
     * @return string
     */
    public function validateData(\Tripsy\Library\CNP\Data $cnp_data) : string {
        return $this->is_empty($cnp_data->getCountyKey(), 'invalid_county_code')
                    ->is_date($cnp_data->getBirthdate(), 'invalid_birthdate');
    }

    /**
     * Verification for control digit
     *
     * @param mixed $var
     *
     * @return bool
     */
    private function checkControlDigit($var) : bool {
        $control_digit = $this->calculateControlDigit($var);

        //compoare 13 with calculated control digit
        if(!isset($var[12]) || $control_digit != $var[12]) {
            return false;
        }

        return true;
    }

    /**
     * Calculate control digit based on cnp string
     *
     * @param mixed $var
     *
     * @return int
     */
    private function calculateControlDigit($var) : int {
        $control_number_array = str_split(self::CONTROL_NUMBER);

        $total = 0;

        foreach($control_number_array as $k => $v) {
            if (isset($var[$k])) {
                $total += $v * intval($var[$k]);
            }
        }

        $modulo = $total % 11;

        return $modulo == 10 ? 1 : $modulo;
    }
}