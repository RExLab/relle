<?php
use App\Http\Controllers\LabsController;
function getRandomDifferent($n, $nums) {
    $rand = rand(0, $n - 1);
    if(!in_array($rand, $nums))
        return $rand;
    else
        $rand = getRandomDifferent(0, $n - 1);
}
function labsSuggestion($subject, $n, $id) {
    $subject = \App\Subjects::select('id')->where('name', $subject)->first()->toArray();
    $rel = App\SubjectsLabs::where('subject_id', $subject['id'])
                    ->where('lab_id', '<>', $id)
                    ->take($n)->get();
    $labs = [];
    foreach ($rel as $one) {
        $lab = App\Labs::find($one->lab_id);
        array_push($labs, $lab);
    }
    return $labs;
}
function formatIcon($doc) {
    $format = 'other';
    switch ($doc) {
        case 'pdf': $format = 'pdf';
            break;
        case 'doc': $format = 'doc';
            break;
        case 'docx': $format = 'doc';
            break;
        case 'ppt': $format = 'ppt';
            break;
        case 'pptx': $format = 'ppt';
            break;
        case 'xls': $format = 'xls';
            break;
        case 'xlsx': $format + 'xls';
            break;
        case 'txt': $format = 'txt';
            break;
        default: $format = 'other';
            break;
    }
    return $format;
}
function formatSize($bytes, $precision = 0) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
function guest() {
    if (Auth::check())
        if (Auth::user()->username == 'fpuntel' || Auth::user()->username == 'marisa.cavalcante')
            return true;
    return false;
}
function country() {
    //$data = DB::select('SELECT  UPPER(`country`) , COUNT(`country`) FROM `logs` WHERE YEARWEEK(`start`, 1 ) = YEARWEEK(CURDATE() , 1 )  GROUP BY  `country`');
    $data = DB::select('SELECT  UPPER(`country`) , COUNT(`country`) FROM `logs` GROUP BY  `country` ');
    $output = array();
    $value = "COUNT(`country`)";
    $country = "UPPER(`country`)";
    $i = 0;
    foreach ($data as $place) {
        $output[$i]['country'] = trans('country.' . $place->$country);
        $output[$i]['value'] = $place->$value;
        $i++;
    }
    /*
      $output = usort($output, function ($a, $b) {
      return $a['value'] > $b['value'];
      });
     */
    return $output;
}
function arrayToString($array) {
    if (count($array) == 1) {
        return $array[0];
    } else {
        return implode(',', $array);
    }
}
function stringToArray($string) {
    if (substr_count($string, ',') > 0) {
        return explode(',', $string);
    } else {
        return array($string);
    }
}
function unzipLab($pathToZip, $expId) {
    $zip = new ZipArchive;
    $res = $zip->open($pathToZip);
    $path = "/public/exp_data/" . $expId;
    $final_path = base_path() . $path;
    $reports_path = base_path() . "/resources/views/reports/" . $expId;
    shell_exec("mkdir -p " . $final_path);
    shell_exec("chmod 777 " . $final_path);
    shell_exec("mkdir -p " . $reports_path); //Reports
    shell_exec("chmod 777 " . $reports_path);  //Reports
    if ($res === TRUE) {
        $zip->extractTo(base_path() . $path);
        shell_exec("mv " . base_path() . $path . "/report_en.blade.php " . $reports_path . "/report_en.blade.php"); //Reports
        shell_exec("mv " . base_path() . $path . "/report_pt.blade.php " . $reports_path . "/report_pt.blade.php"); //Reports
        $zip->close();
    } else {
        $zip->close();
        echo "Unable to unzip your zip archive.";
    }
}
function getLastLabId() {
    $last = DB::table('labs')->orderBy('id', 'desc')->first();
    if (empty($last)) {
        return 1;
    } else {
        return $last->id + 1;
        //return Labs::orderBy('id')->first();
    }
}
function searchDocs($input) {
    $result = null;
    $first = true;
    $general = '';
    if (!empty($input['terms'])) {
        $string = $input['terms'];
        $terms = explode(' ', $string);
        $n = count($terms);
        $i = 1;
        foreach ($terms as $term) {
            $general .= "title like '%$term%' or "
                    . "tags like '%$term%'";
            if ($i < $n) {
                $general.=' or ';
                $i++;
            }
        }
        $first = false;
        
        $query = "select * from docs where " . $general;
        $result = DB::select($query);
        return $result;
    }
    return "";
}
function searchLabs($input) {
    $result = null;
    $first = true;
    $general = '';
    if (!empty($input['terms'])) {
        $string = $input['terms'];
        $terms = explode(' ', $string);
        $n = count($terms);
        $i = 1;
        foreach ($terms as $term) {
            $general .= "name_pt like '%$term%' or "
                    . "name_en like '%$term%' or "
                    . "description_pt like '%$term%' or "
                    . "description_en like '%$term%' or "
                    . "tags like '%$term%'";
            if ($i < $n) {
                $general.=' or ';
                $i++;
            }
        }
        $first = false;
    
        $query = "select * from labs where " . $general;
        $result = DB::select($query);
        return $result;
    }
    return "";
}
function handleSearchVariables($array, $var, $first, $specific) {
    if (array_key_exists($var, $array)) {
        if (empty($specific)) {
            $specific = '';
        } else {
            $specific = ' and ';
        }
        if ($first == false) {
            $specific .= ' and';
        }
        if (count($array[$var]) == 1) {
            $string = $array[$var][0];
            $specific.=" $var like '%$string%'";
        } else {
            $aux = $array[$var];
            $specific.="$var = '$aux[0]'";
            for ($i = 1; $i < count($array) - 1; $i++) {
                $specific.=" or $var like '%$aux[$i]%'";
            }
        }
        return $specific;
    } else {
        return '';
    }
}
function getFlag() {
    if (App::getLocale() == 'pt') {
        return 'en';
    } else {
        return 'pt';
    }
}
function getAvailableAppLangArray() {
    $locales[''] = Lang::get('app.select_your_language');
    foreach (Config::get('app.locales') as $key => $value) {
        $locales[$key] = $value;
    }
    return $locales;
}
function getGuestData() {
    return [
        'avatar' => 'img/default.gif',
        'firstname' => trans('users.guest')
    ];
}
/*
 * Editing data on moodle database
 */
function moodle_db($query) {
    $dbhost = "localhost";
    $dbname = "moodle";
    $dbusername = "root";
    $dbpassword = "RExLab!)%";
    try {
        $link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
        $statement = $link->prepare($query);
        $statement->execute();
    } catch (Exception $e) {
        echo 'error Moodle';
        die;
    }
}
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function admin() {
    if (Auth::user()) {
        if (Auth::user()->type == 'admin') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
function teacher() {
    if (Auth::user()) {
        if (Auth::user()->type == 'teacher' || Auth::user()->type == 'admin') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function isMobile($useragent) {
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        return true;
    } else {
        return false;
    }
}
function status($id) {
    $query = 'select e.lab_id from instances e where not exists (select null from instances i where e.lab_id = i.lab_id and `maintenance` = 0)';
    $out = DB::select($query);
    foreach ($out as $one) {
        if ($one->lab_id == $id) {
            return false;
        }
    }
    return true;
}