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
    private $string;
    private const CONTROL_NUMBER = 279146358279;

    public function __construct(string $string) {

        $this->string = trim($string);
    }

    public function validateFormat() : string {
        return $this->is_empty($this->string, 'empty_string')
                    ->is_length($this->string, 13, 13, 'invalid_length')
                    ->is_number($this->string, 'invalid_chars')
                    ->checkControlDigit($this->string, 'control_number_fail');
    }

    public function validateData(\Tripsy\Library\CNP\Data $cnp_data) : string {
        return $this->is_empty($cnp_data->getCountyKey(), 'invalid_county_code')
                    ->is_date($cnp_data->getBirthdate(), 'invalid_birthdate');
    }

    private function checkControlDigit($var, $msg) : self {
		//condition
		if ($this->message) {
            //return
            return $this; //break if message already set -> this enable chain verification
        }

        $control_digit = $this->calculateControlDigit($var);

		//verification
		if(!isset($var[12]) || $control_digit != $var[12]) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
    }

    private function calculateControlDigit($var) : int {
        $control_number_array = str_split(self::CONTROL_NUMBER);

        $total = 0;

        foreach($control_number_array as $k => $v) {
            if (isset($var[$k])) {
                $total += $v * $var[$k];
            }
        }

        $modulo = $total % 11;

        return $modulo == 10 ? 1 : $modulo;
    }
}