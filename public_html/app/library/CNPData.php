<?php
/*****************************************************************************
* library/CNPData.php
*
* Author: David Gabriel
*
*****************************************************************************/

namespace Test\Library;

class CNPData
{
    private $string;
    private $data = array(
        'gender' => null,
        'birthdate' => null,
        'county_code_key' => null,
        'county_code_name' => null,
    );

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

    public function __construct(string $string) {
        $this->string = trim($string);
    }

    public function getData() {
        $this->extractGender();
        $this->extractBirthdate();
        $this->extractCountyCode();

        return $this->data;
    }

    private function extractGender() {
        if (isset($this->string[0])) {
            if (in_array($this->string[0], array('1', '3', '5', '7'))) {
                $this->data['gender'] = 'male';
            } else if  (in_array($this->string[0], array('2', '4', '6', '8'))) {
                $this->data['gender'] = 'female';
            } else if ($this->string[0] == '9') {
                $this->data['gender'] = 'n/a';
            }
        }
    }

    private function extractBirthdate() {
        if (strlen($this->string) == 13) {
            $this->data['birthdate'] = $this->string[1].$this->string[2].'-'.$this->string[3].$this->string[4].'-'.$this->string[5].$this->string[6];

            if (in_array($this->string[0], array('1', '2'))) {
                $this->data['birthdate'] = '19'.$this->data['birthdate'];
            } else if (in_array($this->string[0], array('3', '4'))) {
                $this->data['birthdate'] = '18'.$this->data['birthdate'];
            } else if (in_array($this->string[0], array('5', '6'))) {
                $this->data['birthdate'] = '20'.$this->data['birthdate'];
            }
        }
    }

    private function extractCountyCode() {
        if (strlen($this->string) == 13) {
            $k = $this->string[7].$this->string[8];

            if ($n = $this->getCountyName($k)) {
                $this->data['county_code_key'] = $k;
                $this->data['county_code_name'] = $n;
            }
        }
    }

    public function getCountyName($k) {
        if (array_key_exists($k, self::ARR_COUNTY_CODE)) {
            return self::ARR_COUNTY_CODE[$k];
        }
    }
}