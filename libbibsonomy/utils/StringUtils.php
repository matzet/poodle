<?php

/*
 *
 *  Copyright (C) 2006 - 2013 Knowledge & Data Engineering Group,
 *                            University of Kassel, Germany
 *                            http://www.kde.cs.uni-kassel.de/
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * StringUtils contains a set of static methods to operate with strings, needed
 * to serialize/normalize person names, titles, years and so on.
 *
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class StringUtils {

    const WHITE_SPACE = "!\s+!";
    const AT_LEAST_TWO_WHITE_SPACES = "!\s\s+!";
    const SINGLE_NUMBER = "!\b\d+\b!";
    const FOUR_NUMBERS = "!.*(\d{4}).*!";
    const NON_NUMBERS = "![^0-9]+!";
    const NON_NUMBERS_OR_LETTERS = "![^0-9\p{L}]+!";
    const NON_NUMBERS_OR_LETTERS_OR_DOTS_OR_SPACE = "![^0-9\p{L}\. ]+!";
    const NON_NUMBERS_OR_LETTERS_OR_DOTS_OR_COMMA_OR_SPACE = "![^0-9\p{L}\., ]+!";
    const NON_LETTERS_OR_DOTS_OR_COMMA_OR_SEMICOLON_OR_SPACE = "![^\p{L}\.,;\s]+!";
    const TITLE_SOURCE_SPLIT_PATTERN = "!^(.+),\s?(\d{4}),\s?Vol\.\s?(\d+),\s?Issue\s?(\d+),\s?p\.\s?(\d+)$!";
    const DATE_YEAR_PATTERN = "!";

    /**
     * Removes everything which is neither a number nor a letter.
     * 
     * @param string source string
     * @return string result
     */
    public static function removeNonNumbersOrLetters($string) {

        return preg_replace(self::NON_NUMBERS_OR_LETTERS, "", $string);
    }

    /**
     * Removes everything, but numbers.
     * 
     * @param string source string
     * @return string result
     */
    public static function removeNonNumbers($string) {

        return preg_replace(self::NON_NUMBERS, "", $string);
    }

    /**
     * All strings in the array are concatenated and returned as one single
     * string, i.e. like <code>[item1,item2,item3,...]</code>.
     * 
     * @param array collection of strings to be concatenated
     * 
     * @return string, i.e. like
     *         <code>[item1,item2,item3,...]</code>.
     */
    public static function getStringFromList($array) {

        if (!is_array($array))
            return "[]";
        else
            return "[" . implode(",", $array) . "]";
    }

    /**
     * Removes everything which is neither a number nor a letter nor a dot (.)
     * nor a comma nor nor space. 
     * 
     * Note: does not remove whitespace around the numbers!
     * 
     * @param string source string
     * @return string result
     */
    public static function removeNonNumbersOrLettersOrDotsOrCommaOrSpace($string) {

        return preg_replace(self::NON_NUMBERS_OR_LETTERS_OR_DOTS_OR_COMMA_OR_SPACE, "", $string);
    }

    /**
     * Removes everything which is neither a letter nor a dot (.) nor a comma nor
     * a semicolon nor white space. 
     * @param type $string
     * @return type 
     */
    public static function removeNonLettersOrDotsOrCommaOrSemicolonOrSpace($string) {

        return preg_replace(self::NON_LETTERS_OR_DOTS_OR_COMMA_OR_SEMICOLON_OR_SPACE, "", $string);
    }

    /**
     * two or more spaces in a row will be replaced by a single space character. 
     * 
     * @param string $title 
     * @return string cleaned title
     */
    public static function cleanTitle($title) {
        $title = strip_tags($title);
        return trim(preg_replace(self::AT_LEAST_TWO_WHITE_SPACES, " ", $title));
    }

    /**
     * decodes html entities, removes tags, converts to utf8 and removes double, 
     * triple (a.s.o.) white spaces
     * 
     * @param string $title
     * @return string
     */
    public static function cleanTitle2($title) {
        
        $enc = mb_detect_encoding($title);
       
        if($enc != "UTF-8") {
            $title = utf8_encode($title);
        }
        
        $title = self::html_entity_decode_numeric($title);
        
        return self::cleanTitle($title); 
    }

    /**
     *
     * @param string $string
     * @param string $pattern
     * @return array|boolean 
     */
    public static function split($string, $pattern) {

        return preg_split($pattern, $string);
    }

    /**
     * Returns the year from an string containing substring like: JAN 19, 2013
     * @param string $titleSource
     * @return string 
     */
    public static function extractDateYearFromTitleSource($titleSource) {
        $matches = array();

        if (preg_match("!.*[A-Za-z]{3} \d{1,2}, (\d{4}).*!", $titleSource, $matches)) {
            return $matches[1];
        }
        return "";
    }

    /**
     * Extracts four digits (year) from a string.
     * If a year pattern will be found it returns them, otherwise an empty string.
     * 
     * @param type $string
     * @return string 
     */
    public static function extractYear($string) {

        $matches = array();

        if (preg_match(self::FOUR_NUMBERS, $string, $matches)) {
            return $matches[1];
        }
        return "";
    }

    /**
     *
     * @param string $titleSource
     * @return array
     * @throws Exception 
     */
    public static function splitTitleSource($titleSource) {
        $matches = array();
        if (!preg_match(self::TITLE_SOURCE_SPLIT_PATTERN, $titleSource, $matches)) {
            throw new Exception("Pattern not found!");
        }
        return $matches;
    }

    /**
     *
     * @param string $titleSource
     * @return string 
     */
    public static function extractJournalTitle($titleSource) {
        $array = self::splitTitleSource($titleSource);
        return $array[1];
    }

    /**
     *
     * @param string $titleSource
     * @return string 
     */
    public static function extractYearFromTitleSource($titleSource) {

        $matches = self::splitTitleSource($titleSource);
        return $matches[2];
    }

    /**
     *
     * @param string $titleSource
     * @return string 
     */
    public static function extractVolume($titleSource) {
        $array = self::splitTitleSource($titleSource);
        return $array[3];
    }

    /**
     *
     * @param string $titleSource
     * @return string 
     */
    public static function extractIssue($titleSource) {
        $array = self::splitTitleSource($titleSource);
        return $array[4];
    }

    /**
     *
     * @param string $titleSource
     * @return string 
     */
    public static function extractPage($titleSource) {
        $array = self::splitTitleSource($titleSource);
        return $array[5];
    }

    /**
     * Converts an array of objects to an array of strings.
     * ATTENTION: The __toString() method has to be implemented in ALL objects, 
     * which the array contains.
     * 
     * @param array $array 
     * @return array
     */
    public static function toStringArray($array) {
        $retArray = array();
        foreach ($array as $item) {
            $retArray[] = "$item";
        }
        return $retArray;
    }

    /**
     * Decodes utf8 url params. Especially needed for decoding ajax get params.
     * 
     * @param string $str
     * @return string
     */
    public static function utf8_urldecode($str) {
        $str = preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($str));
        return html_entity_decode($str, null, 'UTF-8');
    }

    public static function toASCII($str) {
        return strtr(utf8_decode($str), utf8_decode(
                        'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'), 'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
    }

    /**
      public static function toUTF8($str) {

      $enc = mb_detect_encoding($str);

      if($enc !== 'UTF-8') {
      return mb_convert_encoding($str, 'UTF-8', $enc);
      }
      return $str;
      }
     */

    /**
     * Decodes all HTML entities, including numeric and hexadecimal ones.
     * 
     * @param mixed $string
     * @return string decoded HTML
     */
    public static function html_entity_decode_numeric($string, $quote_style = ENT_COMPAT, $charset = "utf-8") {
        $string = html_entity_decode($string, $quote_style, $charset);
        $string = preg_replace_callback('~&#x([0-9a-fA-F]+);~i', "self::chr_utf8_callback", $string);
        $string = preg_replace('~&#([0-9]+);~e', 'self::chr_utf8("\\1")', $string);
        return $string;
    }

    /**
     * Callback helper 
     */
    private static function chr_utf8_callback($matches) {
        return self::chr_utf8(hexdec($matches[1]));
    }

    /**
     * Multi-byte chr(): Will turn a numeric argument into a UTF-8 string.
     * 
     * @param mixed $num
     * @return string
     */
    private static function chr_utf8($num) {
        if ($num < 128)
            return chr($num);
        if ($num < 2048)
            return chr(($num >> 6) + 192) . chr(($num & 63) + 128);
        if ($num < 65536)
            return chr(($num >> 12) + 224) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
        if ($num < 2097152)
            return chr(($num >> 18) + 240) . chr((($num >> 12) & 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
        return '';
    }

}

?>
