<?php

/**
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

require_once __DIR__.'/../BibsonomyPublication.php';
require_once __DIR__.'/../Person.php';
require_once __DIR__.'/StringUtils.php';

/**
 * SimHashUtils contains a set of static methods to serialize and normalize 
 * person names and titles. The function getSimHash1 calculates the interhash of 
 * a BibsonomyPublication. 
 *
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class SimHashUtils {
    //put your code here
    
    /**
     * @var string 
     */
    const SINGLE_LETTER = "!(\p{L})!";

    /**
     * By default, all author and editor names are in "Last, First" order
     * @var bool
     */
    const DEFAULT_LAST_FIRST_NAMES = true;
    
    /**
     * the delimiter used for separating person names
     * @var string
     */
    const PERSON_NAME_DELIMITER = " and ";
    
    
    /**
     * the delimiter used for separating first and last name
     */
    const FIRSTNAME_LASTNAME_DELIMITER = ", ";
    
    /**
     * 
     * 
     * @param BibsonomyPublication $record an object that implements interface BibsonomyPublication
     * @return type 
     */
    public static function getSimHash1(BibsonomyPublication $record) {	
        
        
        if(strcmp(StringUtils::removeNonNumbersOrLetters( self::serializePersonNames($record->getAuthors()) ), "") === 0) {
            // no author set --> take editor
            $str =  self::getNormalizedTitle($record->getTitle()) . " " .
                    self::getNormalizedPersons($record->getEditors()) . " " .
                    self::getNormalizedYear($record->getYear());
            
            
        } else {
            // author is set, use it!
            $str =  self::getNormalizedTitle($record->getTitle()) . " " .
                    self::getNormalizedPersons($record->getAuthors()) . " " .
                    self::getNormalizedYear($record->getYear());
        }

        $str = utf8_encode($str);
        return md5($str, false);
    }
    

    /**
     *
     * @param string $string
     * @return string 
     */
    public static function getNormalizedTitle($string) {
            if ( ! is_string($string)) return "";
            return strtolower( StringUtils::removeNonNumbersOrLetters( utf8_decode($string) ) );  //mb_strtolower($string));
    }
    
    /**
     * 
     * @param array $persons – array of strings
     * @return string [name1, name2, name3]
     */
    public static function getNormalizedPersons($persons) {
        if ( ! is_array($persons)) {
            if(is_string($persons)) {
                $persons = array($persons);
            }
        }
	return StringUtils::getStringFromList(self::normalizePersonList($persons));
    }
    
    /**
     *
     * @param string $year 
     */
    public static function getNormalizedYear($year) {
        /*
        if( ! is_numeric($year)) {
            return "";
        }
        */
        return StringUtils::removeNonNumbers($year);
    }
    
    /**
     * Normalizes a collection of persons by normalizing their names 
     * and sorting them.
     *  
     * @param persons - a list of persons. 
     * @return A sorted set of normalized persons.
     */
    public static function normalizePersonList(array $persons) {
        $normalized = array();
        foreach($persons as $person) {
            
            $normalized[] = self::normalizePerson($person);
            
        }
        return $normalized;
    }
    
    /**
     * Used for "sloppy" hashes, i.e., the inter hash.
     * <p>
     * The person name is normalized according to the following scheme:
     * <tt>x.last</tt>, where <tt>x</tt> is the first letter of the first name
     * and <tt>last</tt> is the last name.
     * </p>
     * 
     * Example:
     * <pre>
     * Donald E. Knuth       --&gt; d.knuth
     * D.E.      Knuth       --&gt; d.knuth
     * Donald    Knuth       --&gt; d.knuth
     *           Knuth       --&gt; knuth
     * Knuth, Donald         --&gt; d.knuth
     * Knuth, Donald E.      --&gt; d.knuth
     * Maarten de Rijke      --&gt; m.rijke
     * Balby Marinho, Leandro--&gt; l.marinho
     * </pre>
     * 
     * @param mixed Person|string $person
     * @return string 
     */
    public static function normalizePerson($person = null) {

        
        
        if(is_string($person)) {
            $person_array = Person::createPersonsListFromArray(array($person));
            $person = $person_array[0];

        }
        else if($person == null) {
            return "noperson";
        }

        $first = $person->getFirstName();
        $last  = $person->getLastName();
        
        if( ! empty($first) && empty($last) ) {
            /*
             * Only the first name is given. This should practically never happen,
             * since we put such names into the last name field.
             */
            return strtolower(StringUtils::removeNonNumbersOrLettersOrDotsOrCommaOrSpace( utf8_decode($first) ));
        }
		
        if( ! empty($first) && ! empty($last) ) {
            /*
                * First and last given - default.
                * Take the first letter of the first name and append the last part
                * of the last name.
                */
            return self::getFirst($first) . "." . self::getLast($last);
        }
	
        if( !empty($last) ) {
            /*
             * Only last name available - could be a "regular" name enclosed
             * in brackets.
             */
            return self::getLast($last);
	}
        
        return "";
    }
    
    /**	 
     * Returns the first letter of the first name, or an empty string, if no
     * such letter exists.
     * 
     * @param string first
     * @return string 
     */
    private static function getFirst($first) {
        $matches = array();
        if (preg_match(self::SINGLE_LETTER, $first, $matches)) {
            return strtolower( utf8_decode($matches[1]) );
        }
        return "";
    }
    
    /**
     * Extracts from the last name the last part and cleans it. I.e., from 
     * "van de Gruyter" we get "gruyter"
     * 
     * @param string $last
     * @return string
     */
    private static function getLast($last) {

        $trimmedLast = trim($last);
          
        /*
         * We remove all unusual characters.
         */
        $cleanedLast = trim(strtolower(StringUtils::removeNonNumbersOrLettersOrDotsOrCommaOrSpace( utf8_decode($trimmedLast) ) ) );
        /*
         * If we find a space character, we take the last part of the name
         */
        $pos = strpos($cleanedLast, ' ');
        return $pos > 0 ? substr($cleanedLast, $pos + 1) : $cleanedLast;
    }	
    
    /**
     *
     * @param array<Person> $persons
     * @param bool $lastFirstNames
     * @param string $delimiter
     * @return string|null 
     */
    public static function serializePersonNames(
            array $persons, 
            $lastFirstNames = self::DEFAULT_LAST_FIRST_NAMES, 
            $delimiter = self::PERSON_NAME_DELIMITER) 
    {
        
        if (empty($persons)) return null;
        
        $i = count($persons);
        $ret = "";
	foreach ($persons as $person) {
            --$i;
            $ret .= self::serializePersonName($person, $lastFirstNames);
            if ($i > 0) {
		$ret .= $delimiter;
            }
        }
        return $ret;
    }
	
    /**
     *
     * @param Person $person
     * @param bool $lastFirstName
     * @return null|string 
     */
    public static function serializePersonName(Person $person, $lastFirstName) {
        
	if (is_null($person)) return null;
        
        $first = $last = $delim = "";

        if ($lastFirstName) {
            $first = $person->getLastName();
            $last = $person->getFirstName();
            $delim = $person::LAST_FIRST_DELIMITER . " ";
        } else {
            $first = $person.getFirstName();
            $last = $person.getLastName();
            $delim = " ";
        }

        if ( ! empty($first)) {
            if ( ! empty($last)) {
                return $first . $delim . $last;
            }
            return $first;
        } 
        if (!empty($last)) {
            return $last;
        }
        return null;
    }
    
    /**
     * @param persons
     * @return The first person's last name.
     */
    public static function getFirstPersonsLastName(array $persons) {
        if (!empty($persons)) {
            return $persons[0]->getLastName();
        }
        return null;
    }


}

?>
