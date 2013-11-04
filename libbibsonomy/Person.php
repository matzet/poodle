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
 * Description of Person
 *
 * @author Sebastian Böttger
 */
class Person {
    
    /**
     * delimiter between the parts of a person's name in the "Last, First" format.
     * @var string
     */
    const LAST_FIRST_DELIMITER = ",";
    
    /**
     * Split pattern for person's name in the "Last, First" format
     * @var string 
     */
    const LAST_COMMA_FIRST_SPLIT_PATTERN = "!([^,]+),\s?([^,]+)!";
    
    /**
     * Split pattern for person's name in the "First Last" format
     * @var string 
     */    
    const FIRST_SPACE_LAST_SPLIT_PATTERN = "!^(.*)\ (\p{L}+)$!";
    
    /**
     * Pattern for spliting names by one of the following characters
     * 
     * - at least two space characters
     * - new line
     * - semicolon
     * 
     * @var string 
     */
    const PERSON_NAME_DELIMITER = "!;|(\s\s+)|(</a> ?<a[^>]*href=(?:\"|\')([^>]*)(?:\"|#|\'|mailto:)[^>]*>)!";
    
    const HTML_LINE_BREAK = "!<br ?/?>!";
    
    /**
     *
     * @var string 
     */
    protected $firstName;
    
    /**
     * 
     * @var string 
     */
    protected $lastName;
    
    /**
     * tries to create an array of persons object from an array of strings 
     * 
     * @param array $persons_array
     * @return array<Person> 
     */
    public static function createPersonsListFromArray($persons_array) {
        
        $persons = array();
        
        foreach($persons_array as $p) {
            
            $matches = array();
            
            $p = strip_tags($p); //remove html/xml tags
            //$p = StringUtils::removeNonLettersOrDotsOrCommaOrSemicolonOrSpace($p); 
            try {
                if(preg_match(self::LAST_COMMA_FIRST_SPLIT_PATTERN, $p, $matches)) {
                    $person = new Person(trim($matches[2]), trim($matches[1]));

                } else if(preg_match(self::FIRST_SPACE_LAST_SPLIT_PATTERN, $p, $matches)) {
                    $person = new Person(trim($matches[1]), trim($matches[2]));

                } else if(!empty($p)) {
                    $person = new Person("", $p);                
                    
                } else {
                    continue;
                }
            }
            catch(Exception $e) {
                throw $e;
            }
            $persons[] = $person;
        }
        
        return $persons;
    }
    
    public static function concatAuthorList4BibTeX($authors) {
        
        $ret = "";
        $i = count($authors);
        foreach($authors as $author) {
            --$i;
            $ret .= $author->getLastName().", ";
            $ret .= $author->getFirstName();
            if($i > 0) {
                $ret .= " and ";
            }
        }
        
        return $ret;
    }
    
    /**
     *
     * @param string $firstName
     * @param srting $lastName
     * @throws Exception 
     */
    public function __construct($firstName = "", $lastName = "") {
        if( empty($firstName) && empty($lastName) ) {
            throw new Exception("Firstname or lastname must be set.");
        } 
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }

    public function toString() {
        return $this->__toString();
    }
    
    public function __toString() {
        return $this->lastName . self::LAST_FIRST_DELIMITER . " " . $this->firstName;
    }

    
}

?>
