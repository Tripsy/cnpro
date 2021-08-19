<?php
/*****************************************************************************
* library/cnp/Data.php
*
* Author: David Gabriel
*
*****************************************************************************/

namespace Tripsy\Library\CNP;

class Data
{
    private $string;

    private $gender;
    private $birthdate;
    private $county_key;
    private $county_name;

    private const ARR_COUNTY_CODE = array(
        '01' => 'Alba',
        '02' => 'Arad',
        '03' => 'Argeș',
        '04' => 'Bacău',
        '05' => 'Bihor',
        '06' => 'Bistrița-Năsăud',
        '07' => 'Botoșani',
        '08' => 'Brașov',
        '09' => 'Brăila',
        '10' => 'Buzău',
        '11' => 'Caraș-Severin',
        '12' => 'Cluj',
        '13' => 'Constanța',
        '14' => 'Covasna',
        '15' => 'Dâmbovița',
        '16' => 'Dolj',
        '17' => 'Galați',
        '18' => 'Gorj',
        '19' => 'Harghita',
        '20' => 'Hunedoara',
        '21' => 'Ialomița',
        '22' => 'Iași',
        '23' => 'Ilfov',
        '24' => 'Maramureș',
        '25' => 'Mehedinți',
        '26' => 'Mureș',
        '27' => 'Neamț',
        '28' => 'Olt',
        '29' => 'Prahova',
        '30' => 'Satu Mare',
        '31' => 'Sălaj',
        '32' => 'Sibiu',
        '33' => 'Suceava',
        '34' => 'Teleorman',
        '35' => 'Timiș',
        '36' => 'Tulcea',
        '37' => 'Vaslui',
        '38' => 'Vâlcea',
        '39' => 'Vrancea',
        '40' => 'București',
        '41' => 'București Sector 1',
        '42' => 'București Sector 2',
        '43' => 'București Sector 3',
        '44' => 'București Sector 4',
        '45' => 'București Sector 5',
        '46' => 'București Sector 6',
        '51' => 'Călărași',
        '52' => 'Giurgiu',
    );

    /**
     * @param string $string
     */
    public function __construct(string $string) {
        $this->string = trim($string);
    }

    /**
     * Extract gender value (male, female OR n/a) from string (cnp)
     *
     * @return string
     */
    public function getGender() : string {
        if ($this->gender) {
            return $this->gender;
        }

        if (isset($this->string[0])) {
            if (in_array($this->string[0], array('1', '3', '5', '7'))) {
                $this->gender = 'male';
            } else if  (in_array($this->string[0], array('2', '4', '6', '8'))) {
                $this->gender = 'female';
            } else if ($this->string[0] == '9') {
                $this->gender = 'n/a';
            }
        }

        return $this->gender;
    }

    /**
     * Extract birthdate value (Y-m-d) from string (cnp)
     *
     * @return string
     */
    public function getBirthdate() : string {
        if ($this->birthdate) {
            return $this->birthdate;
        }

        if (strlen($this->string) == 13) {
            $birthdate = $this->string[1].$this->string[2].'-'.$this->string[3].$this->string[4].'-'.$this->string[5].$this->string[6];

            //add year prefix
            if (in_array($this->string[0], array('1', '2'))) {
                $this->birthdate = '19'.$birthdate;
            } else if (in_array($this->string[0], array('3', '4'))) {
                $this->birthdate = '18'.$birthdate;
            } else if (in_array($this->string[0], array('5', '6'))) {
                $this->birthdate = '20'.$birthdate;
            }
        }

        return $this->birthdate; //string Y-m-d
    }

    /**
     * Return county code key if defined
     *
     * @return int
     */
    public function getCountyKey() : int {
        if ($this->county_key) {
            return $this->county_key;
        }

        if (strlen($this->string) == 13) {
            $k = $this->string[7].$this->string[8];

            if ($this->getCountyName($k)) {
                $this->county_key = $k;
            }
        }

        return $this->county_key;
    }
    /**
     * Return county name if defined
     *
     * @param int $k
     *
     * @return string
     */
    public function getCountyName(int $k) : string {
        if (array_key_exists($k, self::ARR_COUNTY_CODE)) {
            $this->county_name = self::ARR_COUNTY_CODE[$k];
        }

        return $this->county_name;
    }
}