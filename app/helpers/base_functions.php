<?php

use Illuminate\Support\Facades\Session;

function format_number($number, $num_decimal = 2, $edit = 0)
{
    if (!is_numeric($number)) $number = floatval($number);
    $sep = ($edit == 0 ? array(",", ".") : array(".", ""));
    $stt = -1;
    $return = number_format($number, $num_decimal, $sep[0], $sep[1]);

    for ($i = $num_decimal; $i > 0; $i--) {
        $stt++;
        if (intval(substr($return, -$i, $i)) == 0) {
            $return = number_format($number, $stt, $sep[0], $sep[1]);
            break;
        }
    }

    return $return;
}

function myEndCode($string)
{
    if (empty($string)) return '';
    $string = base64_encode(json_encode($string));
    $string = str_replace("m", "| |", $string);
    $string = str_replace("M", ": :", $string);
    $string = str_replace("O", "{ }", $string);
    $string = str_replace("J", " ", $string);
    return $string;
}

function myDecode($string)
{
    if (empty($string)) return '';
    $string = str_replace("| |", "m", $string);
    $string = str_replace(": :", "M", $string);
    $string = str_replace("{ }", "O", $string);
    $string = str_replace(" ", "J", $string);
    $string = json_decode(base64_decode($string), true);
    return $string;
}

function validateTitle($str)
{
    $arr = array("&quot;", "&#34;", "\"", "‘", "&apos;", "&#39;", "'", "&laquo;", "&#171;", "«", "&raquo;", "&#187;", "»", "?", ":", "“", "”", "(", ")", "!", "-", "_", "[", "]", "{", "}", "|", "\\", "/", "%", "#", "&", "@", "$", "^", "&", "*", "+", ".", "=", ";", "<", ">", "...", "…", "lt", "  ");
    $str = trim(str_replace($arr, " ", $str));
    $str = remove_uper_char($str);
    return $str;
}

function utf8_for_xml($string)
{
    $string = str_replace("\"", "", $string);
    return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
}

function cut_string($str, $length, $char = " ...")
{
    return \Illuminate\Support\Str::limit($str, $length);

    //Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
    $strlen = mb_strlen($str, "UTF-8");
    if ($strlen <= $length) return $str;

    //Cắt chiều dài chuỗi $str tới đoạn cần lấy
    $substr = mb_substr($str, 0, $length, "UTF-8");
    if (mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;

    //Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
    $strPoint = mb_strrpos($substr, " ", "UTF-8");

    //Return string
    if ($strPoint < $length - 20) return $substr . $char;
    else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
}

function remove_uper_char($mystring)
{
    $marThuong = array(
        "a", "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "b", "c", "d", "đ",
        "e", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "f", "g", "h",
        "i", "ì", "í", "ị", "ỉ", "ĩ",
        "j", "k", "l", "m", "n",
        "o", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "p", "q", "r", "s", "t",
        "u", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "v", "w", "x",
        "y", "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "z",
        "'");
    $marHoa = array(
        "A", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "B", "C", "D", "Đ",
        "E", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "F", "G", "H",
        "I", "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "J", "K", "L", "M", "N",
        "O", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "P", "Q", "R", "S", "T",
        "U", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "V", "W", "X",
        "Y", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Z",
        "");

    return str_replace($marHoa, $marThuong, $mystring);

}

function convertToUnicode($string)
{
    $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    $string = replaceNCR($string);
    $trans = array("á" => "á", "à" => "à", "ả" => "ả", "ã" => "ã", "ạ" => "ạ", "ă" => "ă", "ắ" => "ắ",
        "ằ" => "ằ", "ẳ" => "ẳ", "ẵ" => "ẵ", "ặ" => "ặ", "â" => "â", "ấ" => "ấ", "ầ" => "ầ", "ẩ" => "ẩ",
        "ậ" => "ậ", "ẫ" => "ẫ", "ó" => "ó", "ò" => "ò", "ỏ" => "ỏ", "õ" => "õ", "ọ" => "ọ", "ô" => "ô",
        "ố" => "ố", "ồ" => "ồ", "ổ" => "ổ", "ỗ" => "ỗ", "ộ" => "ộ", "ơ" => "ơ", "ớ" => "ớ", "ờ" => "ờ",
        "ở" => "ở", "ỡ" => "ỡ", "ợ" => "ợ", "ú" => "ú", "ù" => "ù", "ủ" => "ủ", "ũ" => "ũ", "ụ" => "ụ",
        "ư" => "ư", "ứ" => "ứ", "ừ" => "ừ", "ử" => "ử", "ự" => "ự", "ữ" => "ữ", "é" => "é", "è" => "è",
        "ẻ" => "ẻ", "ẽ" => "ẽ", "ẹ" => "ẹ", "ê" => "ê", "ế" => "ế", "ề" => "ề", "ể" => "ể", "ễ" => "ễ",
        "ệ" => "ệ", "í" => "í", "ì" => "ì", "ỉ" => "ỉ", "ĩ" => "ĩ", "ị" => "ị", "ý" => "ý", "ỳ" => "ỳ",
        "ỷ" => "ỷ", "ỹ" => "ỹ", "ỵ" => "ỵ", "đ" => "đ", "Á" => "Á", "À" => "À", "Ả" => "Ả", "Ã" => "Ã",
        "Ạ" => "Ạ", "Ă" => "Ă", "Ắ" => "Ắ", "Ằ" => "Ằ", "Ẳ" => "Ẳ", "Ẵ" => "Ẵ", "Ặ" => "Ặ", "Â" => "Â",
        "Ấ" => "Ấ", "Ầ" => "Ầ", "Ẩ" => "Ẩ", "Ậ" => "Ậ", "Ẫ" => "Ẫ", "Ó" => "Ó", "Ò" => "Ò", "Ỏ" => "Ỏ",
        "Õ" => "Õ", "Ọ" => "Ọ", "Ô" => "Ô", "Ố" => "Ố", "Ồ" => "Ồ", "Ổ" => "Ổ", "Ỗ" => "Ỗ", "Ộ" => "Ộ",
        "Ơ" => "Ơ", "Ớ" => "Ớ", "Ờ" => "Ờ", "Ở" => "Ở", "Ỡ" => "Ỡ", "Ợ" => "Ợ", "Ú" => "Ú", "Ù" => "Ù",
        "Ủ" => "Ủ", "Ũ" => "Ũ", "Ụ" => "Ụ", "Ư" => "Ư", "Ứ" => "Ứ", "Ừ" => "Ừ", "Ử" => "Ử", "Ữ" => "Ữ",
        "Ự" => "Ự", "É" => "É", "È" => "È", "Ẻ" => "Ẻ", "Ẽ" => "Ẽ", "Ẹ" => "Ẹ", "Ê" => "Ê", "Ế" => "Ế",
        "Ề" => "Ề", "Ể" => "Ể", "Ễ" => "Ễ", "Ệ" => "Ệ", "Í" => "Í", "Ì" => "Ì", "Ỉ" => "Ỉ", "Ĩ" => "Ĩ",
        "Ị" => "Ị", "Ý" => "Ý", "Ỳ" => "Ỳ", "Ỷ" => "Ỷ", "Ỹ" => "Ỹ", "Ỵ" => "Ỵ", "Đ" => "Đ",
        "&#225;" => "á", "&#224;" => "à", "&#7843;" => "ả", "&#227;" => "ã", "&#7841;" => "ạ", "&#259;" => "ă",
        "&#7855;" => "ắ", "&#7857;" => "ằ", "&#7859;" => "ẳ", "&#7861;" => "ẵ", "&#7863;" => "ặ", "&#226;" => "â",
        "&#7845;" => "ấ", "&#7847;" => "ầ", "&#7849;" => "ẩ", "&#7853;" => "ậ", "&#7851;" => "ẫ", "&#243;" => "ó",
        "&#242;" => "ò", "&#7887;" => "ỏ", "&#245;" => "õ", "&#7885;" => "ọ", "&#244;" => "ô", "&#7889;" => "ố",
        "&#7891;" => "ồ", "&#7893;" => "ổ", "&#7895;" => "ỗ", "&#7897;" => "ộ", "&#417;" => "ơ", "&#7899;" => "ớ",
        "&#7901;" => "ờ", "&#7903;" => "ở", "&#7905;" => "ỡ", "&#7907;" => "ợ", "&#250;" => "ú", "&#249;" => "ù",
        "&#7911;" => "ủ", "&#361;" => "ũ", "&#7909;" => "ụ", "&#432;" => "ư", "&#7913;" => "ứ", "&#7915;" => "ừ",
        "&#7917;" => "ử", "&#7921;" => "ự", "&#7919;" => "ữ", "&#233;" => "é", "&#232;" => "è", "&#7867;" => "ẻ",
        "&#7869;" => "ẽ", "&#7865;" => "ẹ", "&#234;" => "ê", "&#7871;" => "ế", "&#7873;" => "ề", "&#7875;" => "ể",
        "&#7877;" => "ễ", "&#7879;" => "ệ", "&#237;" => "í", "&#236;" => "ì", "&#7881;" => "ỉ", "&#297;" => "ĩ",
        "&#7883;" => "ị", "&#253;" => "ý", "&#7923;" => "ỳ", "&#7927;" => "ỷ", "&#7929;" => "ỹ", "&#7925;" => "ỵ",
        "&#273;" => "đ", "&#193;" => "Á", "&#192;" => "À", "&#7842;" => "Ả", "&#195;" => "Ã", "&#7840;" => "Ạ",
        "&#258;" => "Ă", "&#7854;" => "Ắ", "&#7856;" => "Ằ", "&#7858;" => "Ẳ", "&#7860;" => "Ẵ", "&#7862;" => "Ặ",
        "&#194;" => "Â", "&#7844;" => "Ấ", "&#7846;" => "Ầ", "&#7848;" => "Ẩ", "&#7852;" => "Ậ", "&#7850;" => "Ẫ",
        "&#211;" => "Ó", "&#210;" => "Ò", "&#7886;" => "Ỏ", "&#213;" => "Õ", "&#7884;" => "Ọ", "&#212;" => "Ô",
        "&#7888;" => "Ố", "&#7890;" => "Ồ", "&#7892;" => "Ổ", "&#7894;" => "Ỗ", "&#7896;" => "Ộ", "&#416;" => "Ơ",
        "&#7898;" => "Ớ", "&#7900;" => "Ờ", "&#7902;" => "Ở", "&#7904;" => "Ỡ", "&#7906;" => "Ợ", "&#218;" => "Ú",
        "&#217;" => "Ù", "&#7910;" => "Ủ", "&#360;" => "Ũ", "&#7908;" => "Ụ", "&#431;" => "Ư", "&#7912;" => "Ứ",
        "&#7914;" => "Ừ", "&#7916;" => "Ử", "&#7918;" => "Ữ", "&#7920;" => "Ự", "&#201;" => "É", "&#200;" => "È",
        "&#7866;" => "Ẻ", "&#7868;" => "Ẽ", "&#7864;" => "Ẹ", "&#202;" => "Ê", "&#7870;" => "Ế", "&#7872;" => "Ề",
        "&#7874;" => "Ể", "&#7876;" => "Ễ", "&#7878;" => "Ệ", "&#205;" => "Í", "&#204;" => "Ì", "&#7880;" => "Ỉ",
        "&#296;" => "Ĩ", "&#7882;" => "Ị", "&#221;" => "Ý", "&#7922;" => "Ỳ", "&#7926;" => "Ỷ", "&#7928;" => "Ỹ",
        "&#7924;" => "Ỵ", "&#039;" => "'", "&#x27;" => "'"
        //"&#272;" => "Đ","&#x27;"=>"`","&#39;"=>"`","&#039;"=>"`","&#x22;"=>"“","&#34;"=>"“","\""=>"“"
    );
    $string = strtr($string, $trans);
    $string = mb_convert_encoding($string, "UTF-8", "UTF-8");
    return $string;
}

function replaceNCR($str)
{
    $codeNCR = array("&#224;", "&#225;", "&#7841;", "&#7843;", "&#227;", "&#226;", "&#7847;", "&#7845;", "&#7853;", "&#7849;", "&#7851;", "&#259;", "&#7857;", "&#7855;", "&#7863;", "&#7859;", "&#7861;",
        "&#232;", "&#233;", "&#7865;", "&#7867;", "&#7869;", "&#234;", "&#7873;", "&#7871;", "&#7879;", "&#7875;", "&#7877;",
        "&#236;", "&#237;", "&#7883;", "&#7881;", "&#297;",
        "&#242;", "&#243;", "&#7885;", "&#7887;", "&#245;", "&#244;", "&#7891;", "&#7889;", "&#7897;", "&#7893;", "&#7895;", "&#417;", "&#7901;", "&#7899;", "&#7907;", "&#7903;", "&#7905;",
        "&#249;", "&#250;", "&#7909;", "&#7911;", "&#361;", "&#432;", "&#7915;", "&#7913;", "&#7921;", "&#7917;", "&#7919;",
        "&#7923;", "&#253;", "&#7925;", "&#7927;", "&#7929;",
        "&#273;",

        "&#192;", "&#193;", "&#7840;", "&#7842;", "&#195;", "&#194;", "&#7846;", "&#7844;", "&#7852;", "&#7848;", "&#7850;", "&#258;", "&#7856;", "&#7854;", "&#7862;", "&#7858;", "&#7860;",
        "&#200;", "&#201;", "&#7864;", "&#7866;", "&#7868;", "&#202;", "&#7872;", "&#7870;", "&#7878;", "&#7874;", "&#7876;",
        "&#204;", "&#205;", "&#7882;", "&#7880;", "&#296;",
        "&#210;", "&#211;", "&#7884;", "&#7886;", "&#213;", "&#212;", "&#7890;", "&#7888;", "&#7896;", "&#7892;", "&#7894;", "&#416;", "&#7900;", "&#7898;", "&#7906;", "&#7902;", "&#7904;",
        "&#217;", "&#218;", "&#7908;", "&#7910;", "&#360;", "&#431;", "&#7914;", "&#7912;", "&#7920;", "&#7916;", "&#7918;",
        "&#7922;", "&#221;", "&#7924;", "&#7926;", "&#7928;",
        "&#272;",
    );

    $codeVN = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",

        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ",
    );

    $str = str_replace($codeNCR, $codeVN, $str);
    return $str;
}

function replaceFCK($string, $type = 0)
{
    $array_fck = array("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Igrave;", "&Iacute;", "&Icirc;",
        "&Iuml;", "&ETH;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ugrave;", "&Uacute;", "&Yacute;", "&agrave;",
        "&aacute;", "&acirc;", "&atilde;", "&egrave;", "&eacute;", "&ecirc;", "&igrave;", "&iacute;", "&ograve;", "&oacute;",
        "&ocirc;", "&otilde;", "&ugrave;", "&uacute;", "&ucirc;", "&yacute;",
    );
    $array_text = array("À", "Á", "Â", "Ã", "È", "É", "Ê", "Ì", "Í", "Î",
        "Ï", "Ð", "Ò", "Ó", "Ô", "Õ", "Ù", "Ú", "Ý", "à",
        "á", "â", "ã", "è", "é", "ê", "ì", "í", "ò", "ó",
        "ô", "õ", "ù", "ú", "û", "ý",
    );
    if ($type == 1) $string = str_replace($array_fck, $array_text, $string);
    else $string = str_replace($array_text, $array_fck, $string);

    return $string;
}

function replace_double_space($input)
{
    return preg_replace('!\s+!', ' ', $input);
}

function clearSpaceBuffer($buffer)
{
    // return $buffer;
    //   if (env('APP_ENV' === 'local')) return $buffer;
    $arrStr = array(chr(9), chr(10));
    $buffer = str_replace($arrStr, "", $buffer);
    $buffer = replace_double_space($buffer);
    // $buffer = str_replace("> <", "><", $buffer);
    return trim($buffer);
}

function removeAccent($mystring)
{
    $marTViet = array(
        // Chữ thường
        "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ", "Đ", "'",
        // Chữ hoa
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ", "Đ", "'",
    );
    $marKoDau = array(
        /// Chữ thường
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d", "D", "",
        //Chữ hoa
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D", "D", "",
    );

    return str_replace($marTViet, $marKoDau, $mystring);
}

function formatSentenceUppercaseWord($text)
{
    $text = mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    $text = str_ireplace("tnhh", "TNHH", $text);
    $arrText = explode(" ", $text);
    foreach ($arrText as $key => $val) {
        if (!preg_match("/([aoeiyeêou])/", strtolower(removeAccent($val)), $match)) {
            $arrText[$key] = mb_strtoupper($val, "UTF-8");
        }
    }
    $text = implode(" ", $arrText);
    return $text;
}

function jsonEncode($arr)
{
    return json_encode($arr, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
}

function jsonDecode($str)
{
    return json_decode($str, 1);
}

function removeHTML($string)
{
    $string = preg_replace('/<script.*?\>.*?<\/script>/si', ' ', $string);
    $string = preg_replace('/<style.*?\>.*?<\/style>/si', ' ', $string);
    $string = preg_replace('/<.*?\>/si', ' ', $string);
    $string = str_replace('&nbsp;', ' ', $string);

    return $string;
}

function replaceMQ($text)
{
    $text = str_replace("\'", "'", $text);
    $text = str_replace("'", "''", $text);

    return $text;
}

function countWord($str)
{
    $str = removeAccent($str);

    return str_word_count($str);
}

function arrGetVal($key, $arr, $defaultValue = '')
{
    $key = explode(".", $key);
    $arrTemp = $arr;
    foreach ($key as $k) {
        if (isset($arrTemp[$k])) {
            $arrTemp = $arrTemp[$k];
        } else {
            $arrTemp = $defaultValue;
        }
    }
    if (!$arrTemp) $arrTemp = $defaultValue;
    return $arrTemp;
}

function format_money($price,$current = 'đ',$text = 'Liên hệ')
{
    if(!$price)
        return $text;
    return number_format($price, 0, '.', '.').''.$current.'';
}

function getCart()
{
    $cart = Session::get('cart', []);
    $totalQuantity = 0;
    if ($cart){
        foreach ($cart as $item) {
            $totalQuantity += $item['quantity'];
        }
    }
    return $totalQuantity;
}

function replace_image($image){
    return str_replace('https://cdn.cocolux.com','/images/cdn_images',$image);
}

function replace_image_home($image){
    return str_replace(
        ['https://cdn.cocolux.com', 'png', 'jpg', 'jpeg'],
        ['/images/thumbs_images', 'webp', 'webp', 'webp'],
        $image
    );
}

function percentage_price($price, $old_price){
    if ($old_price != 0 || $old_price != null){
        $percentageChange = (($price - $old_price) / $old_price) * 100;
        return round($percentageChange).'%';
    }else{
        return '';
    }
}
