<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 25.10.2018
 * Time: 20:41
 */
namespace App\Services;
use App\Category;
class Help
{

    public static function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        if($result !== FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function priceToFloat($s)
    {
        // convert "," to "."
        $s = str_replace(',', '.', $s);

        // remove everything except numbers and dot "."
        $s = preg_replace("/[^0-9\.]/", "", $s);

        // remove all seperators from first part and keep the end
        $s = str_replace('.', '',substr($s, 0, -3)) . substr($s, -3);

        // return float
        return (float) $s;
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    public static function getClassName($name){
        $name = str_replace('/', '\\', $name);
        $name = "App\{$name}";
        $name = str_replace('{', '', $name);
        $name = str_replace('}', '', $name);
        return $name;
    }
  /*  public static function numberDiffrence($first, $second){
        if($first > $second) return $first - $second;
        if($second > $first) return $second - $first;
        return 0;
    }
    public static function similarColors($color_1, $color_2){
        list($r, $g, $b) = sscanf($color_1, "#%02x%02x%02x");
        $first_rbg = [$r, $g, $b];
        list($r, $g, $b) = sscanf($color_2, "#%02x%02x%02x");
        $second_rbg = [$r, $g, $b];
        $r_diff = Help::numberDiffrence($first_rbg[0], $second_rbg[0]);
        $g_diff = Help::numberDiffrence($first_rbg[1], $second_rbg[1]);
        $b_diff = Help::numberDiffrence($first_rbg[2], $second_rbg[2]);
        return $r_diff < 40 && $g_diff < 40 && $b_diff < 40;
    }*/
}
