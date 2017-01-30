<?php
//error_reporting(0);
defined('start') or die('Direct access not allowed.');
function confirm_query($query) { if (!$query) { die("Database Query failed!. Check Database Settings. ->" . mysql_error()); } }
function mysql_prep($value) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    if ($new_enough_php) {
        if ($magic_quotes_active) { $value = stripslashes($value); }
        $value = mysql_real_escape_string($value);
    } else {
        if (!$magic_quotes_active) { $value = addslashes($value); }
    }
    return $value;
}
function imdb_movie($id) {
	//http://www.omdbapi.com/?i=tt3014866&plot=full&r=xml
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.omdbapi.com/?i=".$id."&plot=full&r=xml"); //tt0285331
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = "";
    $output = curl_exec($ch);
    curl_close($ch);
    $doc = "";
    $doc = new SimpleXMLElement($output);
    /*
    print "<pre>";
    print_r($doc);
    print "</pre>";
    */
}
function imdb_download_image($url,$id) {
	if ((!empty($id)) && (!empty($url))) {
        $img = "cache/".$id.".jpg";
        file_put_contents($img,file_get_contents($url));
	}
}
function check($id) {
    $sql = "SELECT * FROM `imdb` WHERE `imdbID`='".$id."'";
    $res = mysql_query($sql);
    confirm_query($res);
	$c = mysql_num_rows($res);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function checkRepeat($id) {
    $sql = "SELECT `repeat` FROM `imdb` WHERE `imdbID`='".$id."'";
    $res = mysql_query($sql);
    confirm_query($res);
    $rows = mysql_num_rows($res);
    if ($rows != 0) {
    	while($t = mysql_fetch_array($res)) {
    		$repeat = $t['repeat'];
    	}
    }
    return $repeat;
}
function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}
function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}
function check_seasons($tt,$number) {
    $sql = "SELECT `seen` FROM `imdb` WHERE `imdbID`='".$tt."' LIMIT 1";
    $res = mysql_query($sql);
    confirm_query($res);
    $rows = mysql_num_rows($res);
    if ($rows != 0) {
    	$values = "";
        while($t = mysql_fetch_array($res)) {
        	$values = $t['seen']; 
        }
        $seen = explode(",",$values);
    }
    if (in_array($number,$seen)) {
		return TRUE;
	} else {
		return FALSE;
	}
}
function count_stats($string,$year) {
	$count = 0;
    $query = "SELECT `id` FROM `imdb` WHERE `Type`='".$string."' AND `when` LIKE '".$year."%'";
    $result = mysql_query($query);
    confirm_query($result);
	$count=mysql_num_rows($result);
	return $count;
}
function check_password($mypassword) {
	$password = "1154";
	$web_dir = "iCTV";
    if($mypassword == $password) {
        ini_set("session.gc_maxlifetime","14400");
		session_name($web_dir);
        session_start();
		$_SESSION[$web_dir] = $web_dir;
		setcookie("iCTV", $web_dir.".eesystems.net", time()+14400, "/".$web_dir."/", $web_dir.".eesystems.net", 0, true);
		$location = "index.php";
        header("location:$location");
	} else {
		$location = "login.php";
        header("location:$location");
	}
}
function check_login(){
	$web_dir = "iCTV";
    if (session_status() == PHP_SESSION_NONE) {
		session_name($web_dir);
        session_start();
    }	
    function check_loggedin($web_dir) {
		if(isset($_SESSION[$web_dir]) && ($_SESSION[$web_dir] == $web_dir)) {
			return TRUE;
        } else {
			return FALSE;
		}
    }
    if (!check_loggedin($web_dir)) {
        //session_destroy();
        $_SESSION[$web_dir] = NULL;
        unset($_COOKIE['iCTV']);
		$location = "login.php";
	    header("location:$location");
    }
    else {
		$_SESSION[$web_dir] = $web_dir;
    }
}




function curPageURL() {
    $pageURL = 'http';
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
class OMDb {
    //API url
    private $url = 'http://www.omdbapi.com/';
    //Request timeout
    private $timeout;
    //Date format
    private $date_format;
    //Default parameters
    private $params = [
        //movie, series, episode or NULL
        'type' => NULL,
        //Year of release or NULL
        'y' => NULL,
        //short, full
        'plot' => 'full',
        //json, if you edit
        //this one you will
        //have to rewrite the
        //parse method
        'r' => 'json',
        //Rotten Tomatoes
        //TRUE, FALSE
        'tomatoes' => FALSE,
        //api version. Don't edit this one
        //if you don't know what you're doing
        'v' => 1
    ];
    //$params = array(param => value)
    //$timeout = request timeout in seconds
    //$date = see this page for format http://php.net/manual/function.date.php,
    //can be NULL and returns UNIX-time
    public function __construct($params = [], $timeout = 5, $date_format = 'Y-m-d') {
        //Set the API parameters
        $this->setParams($params);
        //Set the cURL timeout
        $this->timeout = $timeout;
        //Set the date format
        $this->date_format = $date_format;
    }
    //Set the parameters for the API request
    //$params = array(param => value)
    public function setParams($params) {
        //Make sure $params is an array
        if(is_array($params) !== TRUE) {
            throw new Exception('$params has to be an array.');
        }
	$validParams = array_keys($this->params);
        foreach($params as $param => $value) {
            //lowered key
            $k = strtolower($param);
            //Check if parameter is valid
            //and make an edit to it
            if(in_array($k, $validParams)) {
                $this->params[$k] = $value;
            } else {
                throw new Exception($param . ' isn\'t a valid parameter.');
            }
        }
    }
    //Set only one parameter
    public function setParam($param, $value) {
        //Sends the parameter as an array to the method setParams
        $this->setParams( [ $param => $value ] );
    }
    //Create URL, including id or title params
    //$type = i or t
    //$value = tt[0-9] or title
    private function createURL($type,$value) {
        $params = $this->params;
        //Adds title, id or search
        $params[$type] = $value;

        $tmp_params = [];
        foreach($params as $param => $value) {
            //Bool to string
            if(is_bool($value)) {
                $value = ($value) ? 'true' : 'false';
            }
            //Ignore NULL values
            if(is_null($value) !== TRUE) {
                $tmp_params[$param] = $value;
            }
        }
        $query = http_build_query($tmp_params);
        return $this->url.'?'.$query;
        //echo $this->url.'?'.$query;
    }
    private function createURLsearch($type,$value,$t,$page) {
        $params = $this->params;
        //Adds title, id or search
        $params[$type] = $value;
        $tmp_params = [];
        foreach($params as $param => $value) {
            //Bool to string
            if(is_bool($value)) {
                $value = ($value) ? 'true' : 'false';
            }
            //Ignore NULL values
            if(is_null($value) !== TRUE) {
                $tmp_params[$param] = $value;
            }
        }
        $query = http_build_query($tmp_params);
        if ($t == "all") {
			$url = $this->url."?".$query."&page=".$page;
		} else {
			$url = $this->url."?".$query."&type=".$t."&page=".$page;
		}
        return $url;
    }
    private function createURLseason($type,$value,$season) {
        $params = $this->params;
        //Adds title, id or search
        $params[$type] = $value;

        $tmp_params = [];
        foreach($params as $param => $value) {
            //Bool to string
            if(is_bool($value)) {
                $value = ($value) ? 'true' : 'false';
            }
            //Ignore NULL values
            if(is_null($value) !== TRUE) {
                $tmp_params[$param] = $value;
            }
        }
        $query = http_build_query($tmp_params);
        return $this->url . '?' . $query."&season=".$season;
    }
    //Fetches the url and runs json_decode
    private function request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        $info = curl_getinfo($ch);
        //Checks if the request did succed
        if($info['http_code'] !== 200) {
            throw new Exception(
                'Request failed. HTTP CODE: '
                . $info['http_code']
            );
        }
        return json_decode($content);
    }
    //Handels the requests from get_by_* methods
    private function get_data($url) {
        $request = $this->request($url);
        //Parse the request
        $parsed = $this->parse_result($request);
        return $parsed;
    }
    private function get_season_data($url) {
        $request = $this->request($url);
        //Parse the request
        $parsed = $this->parse_season_result($request);
        return $parsed;
    }
    //Get by IMDb id
    //$id = tt[0-9]
    //returns an array
    public function get_season($id,$season) {
        //Checks if the IMDb id is valud
        if($this->valid_imdb_id($id) === FALSE) {
            throw new Exception('The IMDb id is invalid.');
        }
        //Gets the URL
        $url = $this->createURLseason('i',$id,$season);
        //Gets the data and returns it
        return $this->get_data($url);
    }
    public function get_by_id($id) {
        //Checks if the IMDb id is valid
        if($this->valid_imdb_id($id) === FALSE) {
            throw new Exception('The IMDb id is invalid.');
        }
        //Gets the URL
        $url = $this->createURL('i',$id);
        //Gets the data and returns it
        return $this->get_data($url);
    }
    //Get by title
    //returns an array
    public function get_by_title($title) {
        //Gets the URL
        $url = $this->createURL('t', $title);
        //Gets the data and returns it
        return $this->get_data($url);
    }
    //This function search for multiple movies
    //ignores the plot and tomatoes parameters
    //returns array(
    //      Search => array(Title, Year, imdbID, Type), array(...)
    //              )
    public function search($s,$t,$p) {
        //Gets the URL
        $url = $this->createURLsearch('s',$s,$t,$p);
        //Gets the data and returns it
        return $this->get_data($url);
    }
    private static function valid_imdb_id($id) {
        return preg_match('/^tt\d+?$/', $id);
    }
    //Explodes string
    //foo, bar returns ['foo', 'bar']
    //foo returns foo
    private function parse_many($value) {
        $arr = explode(', ', $value);
        if(count($arr) === 1) {
            return $arr[0];
        }else {
            return $arr;
        }
    }
    //Parses date to
    //to the specified format
    private function parse_date($date) {
        $unix = strtotime($date);
        if(is_null($date) === FALSE) {
            return date($this->date_format, $unix);
        }else {
            return $unix;
        }
    }
    //Parses runtime to return a int with
    //the minutes
    private function parse_runtime($value) {
        return (int)strstr($value, ' min', true);
    }
    //String (with comma) to int
    private function parse_int($value) {
        return (int)str_replace(',', '', $value);
    }
    //Value to float
    private function parse_float($value) {
        return (float)$value;
    }
    //String to Bool
    private function parse_bool($value) {
        if(trim(strtolower($value)) === 'true') {
            return TRUE;
        }else {
            return FALSE;
        }
    }
    //Parses all the result
    //with the connected method
    //and returns an array
    //with the data
    private function parse_result($object) {
        //Rules for how to parse the data
        //date,runtime,many,int,float,bool,search and NULL
        $rules = [
            'Title' => NULL,
            'Year' => NULL,
            'Rated' => NULL,
            'Released' => 'date',
            'Runtime' => 'runtime',
            'Genre' => NULL, //many
            'Director' => NULL, //many
            'Writer' => NULL, //many
            'Actors' => NULL, //many
            'Plot' => NULL,
            'Language' => NULL, //many
            'Country' => NULL, //many
            'Awards' => NULL,
            'Poster' => NULL,
            'Metascore' => 'int',
            'imdbRating' => 'float',
            'imdbVotes' => 'int',
            'imdbID' => NULL,
            'Type' => NULL,
            'totalSeasons' => 'int',
            'totalResults' => 'int',
            'tomatoMeter' => 'int',
            'tomatoImage' => NULL,
            'tomatoRating' => 'float',
            'tomatoReviews' => 'int',
            'tomatoFresh' => 'int',
            'tomatoRotten' => 'int',
            'tomatoConsensus' => NULL,
            'tomatoUserMeter' => 'int',
            'tomatoUserRating' => 'float',
            'tomatoUserReviews' => 'int',
            'DVD' => NULL,
            'BoxOffice' => NULL,
            'Production' => NULL,
            'Website' => NULL,
            'Response' => 'bool',
            'Search' => 'search',
            'Error' => NULL,
            'Season' => 'int',
            'Episodes' => NULL
        ];
        //Object to array
        $unParsed = (array)$object;
        //Holds the parsed data
        $data = [];
        //Calls the appropriate method
        //based on the rule connected
        //with the key
        foreach($unParsed as $key => $value) {
            if($value === 'N/A') {
                $data[$key] = NULL;
            }else {
                $v = $value;
                switch($rules[$key]) {
                    case 'many':
                        $v = $this->parse_many($value);
                        break;
                    case 'date':
                        $v = $this->parse_date($value);
                        break;
                    case 'runtime':
                        $v = $this->parse_runtime($value);
                        break;
                    case 'int':
                        $v = $this->parse_int($value);
                        break;
                    case 'float':
                        $v = $this->parse_float($value);
                        break;
                    case 'bool':
                        $v = $this->parse_bool($value);
                        break;
                    case 'search':
                        //There is multiple titles, parses
                        //each of them and adds them to an array
                        $v = [];
                        foreach($value as $arr) {
                            $v[] = $this->parse_result($arr);
                        }
                        break;
                    default:
                        $v = $value;
                }
                $data[$key] = $v;
            }
        }
        return $data;
    }
}
$countrycodes = array(
  //usage
  //$code = array_search('United States', $countrycodes); // returns 'US'
  //$country = $countrycodes['US']; // returns 'United States'
  'AF' => 'Afghanistan',
  'AX' => '&Aring;land Islands',
  'AL' => 'Albania',
  'DZ' => 'Algeria',
  'AS' => 'American Samoa',
  'AD' => 'Andorra',
  'AO' => 'Angola',
  'AI' => 'Anguilla',
  'AG' => 'Antigua and Barbuda',
  'AR' => 'Argentina',
  'AM' => 'Armenia',
  'AW' => 'Aruba',
  'AU' => 'Australia',
  'AT' => 'Austria',
  'AZ' => 'Azerbaijan',
  'BS' => 'Bahamas (the)',
  'BH' => 'Bahrain',
  'BD' => 'Bangladesh',
  'BB' => 'Barbados',
  'BY' => 'Belarus',
  'BE' => 'Belgium',
  'BZ' => 'Belize',
  'BJ' => 'Benin',
  'BM' => 'Bermuda',
  'BT' => 'Bhutan',
  'BO' => 'Bolivia (Plurinational State of)',
  'BA' => 'Bosnia and Herzegovina',
  'BW' => 'Botswana',
  'BV' => 'Bouvet Island',
  'BR' => 'Brazil',
  'IO' => 'British Indian Ocean Territory (the)',
  'BN' => 'Brunei Darussalam',
  'BG' => 'Bulgaria',
  'BF' => 'Burkina Faso',
  'BI' => 'Burundi',
  'KH' => 'Cambodia',
  'CV' => 'Cabo Verde',
  'CM' => 'Cameroon',
  'CA' => 'Canada',
  'CT' => 'Catalonia',
  'KY' => 'Cayman Islands (the)',
  'CF' => 'Central African Republic (the)',
  'TD' => 'Chad',
  'CL' => 'Chile',
  'CN' => 'China',
  'CX' => 'Christmas Island',
  'CC' => 'Cocos (Keeling) Islands (the)',
  'CO' => 'Colombia',
  'KM' => 'Comoros',
  'CD' => 'Congo (the Democratic Republic of the)',
  'CG' => 'Congo (the)',
  'CK' => 'Cook Islands (the)',
  'CR' => 'Costa Rica',
  'CI' => 'C&ocirc;te d\'Ivoire',
  'HR' => 'Croatia',
  'CU' => 'Cuba',
  'CY' => 'Cyprus',
  'CZ' => 'Czech Republic (the)',
  'DK' => 'Denmark',
  'DJ' => 'Djibouti',
  'DM' => 'Dominica',
  'DO' => 'Dominican Republic (the)',
  'EC' => 'Ecuador',
  'EG' => 'Egypt',
  'SV' => 'El Salvador',
  'EN' => 'England',
  'GQ' => 'Equatorial Guinea',
  'ER' => 'Eritrea',
  'EE' => 'Estonia',
  'ET' => 'Ethiopia',
  'EU' => 'European Union',
  'FK' => 'Falkland Islands (the) [Malvinas]',
  'FO' => 'Faroe Islands (the)',
  'FJ' => 'Fiji',
  'FI' => 'Finland',
  'FR' => 'France',
  'GF' => 'French Guiana',
  'PF' => 'French Polynesia',
  'TF' => 'French Southern Territories (the)',
  'GA' => 'Gabon',
  'GM' => 'Gambia (the)',
  'GE' => 'Georgia',
  'DE' => 'Germany',
  'GH' => 'Ghana',
  'GI' => 'Gibraltar',
  'GR' => 'Greece',
  'GL' => 'Greenland',
  'GD' => 'Grenada',
  'GP' => 'Guadeloupe',
  'GU' => 'Guam',
  'GT' => 'Guatemala',
  'GN' => 'Guinea',
  'GW' => 'Guinea-Bissau',
  'GY' => 'Guyana',
  'HT' => 'Haiti',
  'HM' => 'Heard Island and McDonald Islands',
  'VA' => 'Holy See (the)',
  'HN' => 'Honduras',
  'HK' => 'Hong Kong',
  'HU' => 'Hungary',
  'IS' => 'Iceland',
  'IN' => 'India',
  'ID' => 'Indonesia',
  'IR' => 'Iran (Islamic Republic of)',
  'IQ' => 'Iraq',
  'IE' => 'Ireland',
  'IL' => 'Israel',
  'IT' => 'Italy',
  'JM' => 'Jamaica',
  'JP' => 'Japan',
  'JO' => 'Jordan',
  'KZ' => 'Kazakhstan',
  'KE' => 'Kenya',
  'KI' => 'Kiribati',
  'KP' => 'Korea (the Democratic People\'s Republic of)',
  'KR' => 'Korea (the Republic of)',
  'KW' => 'Kuwait',
  'KG' => 'Kyrgyzstan',
  'LA' => 'Lao People\'s Democratic Republic (the)',
  'LV' => 'Latvia',
  'LB' => 'Lebanon',
  'LS' => 'Lesotho',
  'LR' => 'Liberia',
  'LY' => 'Libya',
  'LI' => 'Liechtenstein',
  'LT' => 'Lithuania',
  'LU' => 'Luxembourg',
  'MO' => 'Macao',
  'MK' => 'Macedonia (the former Yugoslav Republic of)',
  'MG' => 'Madagascar',
  'MW' => 'Malawi',
  'MY' => 'Malaysia',
  'MV' => 'Maldives',
  'ML' => 'Mali',
  'MT' => 'Malta',
  'MH' => 'Marshall Islands (the)',
  'MQ' => 'Martinique',
  'MR' => 'Mauritania',
  'MU' => 'Mauritius',
  'YT' => 'Mayotte',
  'MX' => 'Mexico',
  'FM' => 'Micronesia (Federated States of)',
  'MD' => 'Moldova (the Republic of)',
  'MC' => 'Monaco',
  'MN' => 'Mongolia',
  'ME' => 'Montenegro',
  'MS' => 'Montserrat',
  'MA' => 'Morocco',
  'MZ' => 'Mozambique',
  'MM' => 'Myanmar',
  'NA' => 'Namibia',
  'NR' => 'Nauru',
  'NP' => 'Nepal',
  'NL' => 'Netherlands',
  'AN' => 'Netherlands Antilles',
  'NC' => 'New Caledonia',
  'NZ' => 'New Zealand',
  'NI' => 'Nicaragua',
  'NE' => 'Niger (the)',
  'NG' => 'Nigeria',
  'NU' => 'Niue',
  'NF' => 'Norfolk Island',
  'MP' => 'Northern Mariana Islands (the)',
  'NO' => 'Norway',
  'OM' => 'Oman',
  'PK' => 'Pakistan',
  'PW' => 'Palau',
  'PS' => 'Palestine, State of',
  'PA' => 'Panama',
  'PG' => 'Papua New Guinea',
  'PY' => 'Paraguay',
  'PE' => 'Peru',
  'PH' => 'Philippines (the)',
  'PN' => 'Pitcairn',
  'PL' => 'Poland',
  'PT' => 'Portugal',
  'PR' => 'Puerto Rico',
  'QA' => 'Qatar',
  'RE' => 'R&eacute;union',
  'RO' => 'Romania',
  'RU' => 'Russian Federation (the)',
  'RW' => 'Rwanda',
  'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
  'KN' => 'Saint Kitts and Nevis',
  'LC' => 'Saint Lucia',
  'PM' => 'Saint Pierre and Miquelon',
  'VC' => 'Saint Vincent and the Grenadines',
  'WS' => 'Samoa',
  'SM' => 'San Marino',
  'ST' => 'Sao Tome and Principe',
  'SA' => 'Saudi Arabia',
  'AB' => 'Scotland',
  'SN' => 'Senegal',
  'RS' => 'Serbia',
  'CS' => 'Serbia and Montenegro',
  'SC' => 'Seychelles',
  'SL' => 'Sierra Leone',
  'SG' => 'Singapore',
  'SK' => 'Slovakia',
  'SI' => 'Slovenia',
  'SB' => 'Solomon Islands',
  'SO' => 'Somalia',
  'ZA' => 'South Africa',
  'GS' => 'South Georgia and the South Sandwich Islands',
  'ES' => 'Spain',
  'LK' => 'Sri Lanka',
  'SD' => 'Sudan (the)',
  'SR' => 'Suriname',
  'SJ' => 'Svalbard and Jan Mayen',
  'SZ' => 'Swaziland',
  'SE' => 'Sweden',
  'CH' => 'Switzerland',
  'SY' => 'Syrian Arab Republic',
  'TW' => 'Taiwan (Province of China)',
  'TJ' => 'Tajikistan',
  'TZ' => 'Tanzania, United Republic of',
  'TH' => 'Thailand',
  'TL' => 'Timor-Leste',
  'TG' => 'Togo',
  'TK' => 'Tokelau',
  'TO' => 'Tonga',
  'TT' => 'Trinidad and Tobago',
  'TN' => 'Tunisia',
  'TR' => 'Turkey',
  'TM' => 'Turkmenistan',
  'TC' => 'Turks and Caicos Islands (the)',
  'TV' => 'Tuvalu',
  'UG' => 'Uganda',
  'UA' => 'Ukraine',
  'AE' => 'United Arab Emirates (the)',
  'GB' => 'United Kingdom of Great Britain and Northern Ireland (the)',
  'UK' => 'UK',
  'UM' => 'United States Minor Outlying Islands (the)',
  'US' => 'United States of America',
  'USA' => 'USA',
  'UY' => 'Uruguay',
  'UZ' => 'Uzbekistan',
  'VU' => 'Vanuatu',
  'VE' => 'Venezuela (Bolivarian Republic of)',
  'VN' => 'Viet Nam',
  'VG' => 'Virgin Islands (British)',
  'VI' => 'Virgin Islands (U.S.)',
  'WA' => 'Wales',
  'WF' => 'Wallis and Futuna',
  'EH' => 'Western Sahara',
  'YE' => 'Yemen',
  'ZM' => 'Zambia',
  'ZW' => 'Zimbabwe'
);
?>