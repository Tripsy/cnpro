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
	public $message;

	public function __construct() {
	}

    public function __toString() {
        return is_null($this->message) ? '' : $this->message;
    }

	/**
	 * @return bool
	 */
	public function is_error() : bool {
		if ($this->message) {
			return true;
		}

        return false;
	}

	/**
	 * @return self
	 */
	public function is_test() : self {
		if ($this->message) {
            return $this;
        }

		$this->message = 'test';

		return $this;
	}

	/**
	 * @param bool $expr
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_true(bool $expr, string $msg) : self {
		if ($this->message) {
            return $this;
        }

        if ($expr === true) {
            $this->message = $msg;
        }

		return $this;
	}

	/**
	 * @param mixed $var
	 * @param string $case
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_param($var, string $case, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		switch ($case) {
            case 'page':
                if (!preg_match('/^\d+$/', $var) || $var < 0) {
                    $this->message = $msg;
                }
                break;

            case 'limit':
                if (!preg_match('/^\d+$/', $var) || $var < 0) {
                    $this->message = $msg;
                }
                break;
        }

		return $this;
	}

	/**
	 * @param string $var
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_empty(string $var, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		if (empty($var)) {
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

		return $this;
	}

    /**
     * Check if $var_1 & $var_2 have same value
     *
	 * @param string $var_1
	 * @param string $var_2
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_match(string $var_1, string $var_2, string $msg) : self {
		if ($this->message) {
            return $this;
        }

        if ($var_1 != $var_2) {
            $this->message = $msg;
        }

		return $this;
	}

    /**
     * Check $var by regex $format
     *
	 * @param string $var
	 * @param string $format
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_format(string $var, string $format, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		if (!preg_match($format, $var)) {
            $this->message = $msg;
        }

		return $this;
	}

    /**
     * Check if $var contains provided $invalid chars
     *
	 * @param string $var
	 * @param string $invalid
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_invalid_char(string $var, string $invalid, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		if (array_intersect(str_split($var), str_split($invalid))) {
            $this->message = $msg;
        }

		return $this;
	}

    /**
     * Check $min length of the $var
     *
	 * @param string $var
	 * @param int $limit
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_length_min(string $var, int $limit, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		if(strlen($var) < $limit) {
            $this->message = $msg;
        }

		return $this;
	}

    /**
     * Check $max length of the $var
     *
	 * @param string $var
	 * @param int $limit
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_length_max(string $var, int $limit, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		if(strlen($var) > $limit) {
            $this->message = $msg;
        }

		return $this;
	}

    /**
     * Check $min / $max $var length
     *
	 * @param string $var
	 * @param int $min
	 * @param int $max
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_length(string $var, int $min, int $max, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		$this->is_length_min($var, $min, $msg);
		$this->is_length_max($var, $max, $msg);

		return $this;
	}

    /**
     * Check string if is a valid float number
     *
	 * @param string $var
	 * @param string $msg
	 * @param int|null $min
	 * @param int|null $max
	 *
	 * @return self
	 */
	public function is_number(string $var, string $msg, int $min = null, int $max = null) : self {
		if ($this->message) {
            return $this;
        }

        if(!preg_match('~^\d+(.\d+)?$~', $var)) {
            $this->message = $msg;

            return $this;
        }

        if(!is_null($min) && $var < $min) {
            $this->message = $msg;

            return $this;
        }

        if(!is_null($max) && $var > $max) {
            $this->message = $msg;

            return $this;
        }

		return $this;
    }

    /**
     * Check if string is date based on the provided $format
     *
	 * @param string $var
	 * @param string $msg
	 * @param string $format
	 *
	 * @return self
	 */
	public function is_date(string $var, string $msg, string $format = 'Y-m-d') : self {
		if ($this->message) {
            return $this;
        }

        $d = \DateTime::createFromFormat($format, $var);

        if (!$d || $d->format($format) != $var) {
            $this->message = $msg;
        }

		return $this;
	}

    /**
     * Check link format
     *
	 * @param string $var
	 * @param string $msg
	 *
	 * @return self
	 */
	public function is_link(string $var, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		$this->is_format($var, '/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $msg);

		return $this;
	}

    /**
     * Check string is in $array
     *
	 * @param string $var
	 * @param array $array
	 * @param string $msg
	 *
	 * @return self
	 */
	public function in_array(string $var, array $array, string $msg) : self {
		if ($this->message) {
            return $this;
        }

		if(in_array($var, $array) === false) {
            $this->message = $msg;
        }

		return $this;
	}
}