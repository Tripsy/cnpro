<?php
/*****************************************************************************
* library/Error.php
*
* Author: David Gabriel
*
*****************************************************************************/

namespace Tripsy\Library;

class Error
{
	public $message = '';

	public function __construct() {
	}

    public function __toString() {
        return is_null($this->message) ? '' : $this->message;
    }

	public function is_error() {
        //condition
		if ($this->message) {
			//return
			return true;
		} else {
			//return
			return false;
		}
	}

	public function is_test() {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//message
		$this->message = 'test';

		//return
		return $this;
	}

	public function is_true($expr, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//condition
        if ($expr === true) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
	}

	public function is_param($var, $case, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//case
		switch ($case) {
            case 'page':
                if (!preg_match('/^\d+$/', $var) || $var < 0) {
                    //vars
                    $this->message = $msg;
                }
                break;

            case 'limit':
                if (!preg_match('/^\d+$/', $var) || $var < 0) {
                    //vars
                    $this->message = $msg;
                }
                break;
        }

		//return
		return $this;
	}

	public function is_empty($var, $msg) {//check if value is empty
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		if (empty($var)) {
            //vars
            $this->message = $msg;
        } else {
            if (is_array($var)) {
                foreach ($var as  $v) {
                    if (empty($v))  {
                        $this->message = $msg;

                        break;
                    }
                }
            }
        }

		//return
		return $this;
	}

	public function is_match($var_1, $var_2, $msg) {//check two values if they are equal
		//condition
		if ($this->message) {
            //return
            return $this;
        }

        //verification
        if (is_array($var_2)) {
            if (!in_array($var_1, $var_2)) {
                //vars
                $this->message = $msg;
            }
        } else {
            if ($var_1 != $var_2) {
                //vars
                $this->message = $msg;
            }
        }

		//return
		return $this;
	}

	public function is_format($var, $format, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		if (!preg_match($format, $var)) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
	}

	public function is_invalid_char($var, $special, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		if (array_intersect(str_split($var), str_split($special))) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
	}

	public function is_length_min($var, $limit, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		if(strlen($var) < $limit) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
	}

	public function is_length_max($var, $limit, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		if(strlen($var) > $limit) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
	}

	public function is_length($var, $min, $max, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		$this->is_length_min($var, $min, $msg);
		$this->is_length_max($var, $max, $msg);

		//return
		return $this;
	}

	public function is_number($var, $msg, $min = null, $max = null) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
        if(!preg_match('~^\d+(.\d+)?$~', $var)) {
            //vars
            $this->message = $msg;

            //return
            return $this;
        }

		//verification
        if(!is_null($min) && $var < $min) {
            //vars
            $this->message = $msg;

            //return
            return $this;
        }

		//verification
        if(!is_null($max) && $var > $max) {
            //vars
            $this->message = $msg;

            //return
            return $this;
        }

		//return
		return $this;
    }

	public function is_date($var, $msg, $format = 'Y-m-d') {//check if value is date (eg: YYYY-MM-DD)
		//condition
		if ($this->message) {
            //return
            return $this;
        }

        //vars
        $d = \DateTime::createFromFormat($format, $var);

        //condition
        if (!$d || $d->format($format) != $var) {
            $this->message = $msg;
        }

		//return
		return $this;
	}

	public function is_link($var, $msg) {//check if value is link
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		$this->is_format($var, '/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $msg);

		//return
		return $this;
	}

	public function in_array($var, $array, $msg) {
		//condition
		if ($this->message) {
            //return
            return $this;
        }

		//verification
		if(in_array($var, $array) === false) {
            //vars
            $this->message = $msg;
        }

		//return
		return $this;
	}
}