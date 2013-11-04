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

require_once __DIR__ . '/../BibsonomyPublication.php';
require_once __DIR__ . '/SimHashUtils.php';
require_once __DIR__ . '/EntrytypeMapper.php';

/**
 * 
 * Contains methods to transform an object of type BibsonomyPublication in
 * a stdClass object (in form of BibTeX) and vice versa. This stdClass object can 
 * be encoded to the JSON format (using <code>json_encode</code>), which is 
 * needed for sending the object to API.
 * 
 * @see json_encode()
 * 
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de> 
 */
class BibsonomyPublicationUtils {

    
    public static $stdAttributes = array('bibtexKey', 'title', 'year', 'author', 'editor', 'entrytype');
    
    public static $fullBibtexAttributes = array(
                'bibtexAbstract', 'address', 'annote', 'booktitle', 'chapter', 'crossref', 'edition',
                'howpublished', 'institution', 'organization', 'journal', 'note',
                'number', 'pages', 'publisher', 'school', 'series', 'volume',
                'month', 'year', 'url', 'privnote');
    
    public static $attributeValueLengthLimits = array(
        'volume'        => 255,
        'chapter'       => 255,
        'edition'       => 255,
        'month'         => 45,
        'day'           => 45,
        'howPublished'  => 255,
        'institution'   => 255,
        'organization'  => 255,
        'publisher'     => 255,
        'address'       => 255,
        'school'        => 255,
        'series'        => 255,
        'bibtexKey'     => 255,
        'pages'         => 50,
        'number'        => 45,
        'crossref'      => 255,
        'entrytype'     => 30,
        'year'          => 45
    );
    
    
    /**
     *     /**
     * Converts an object of type <code>BibsonomyPublication</code> to a BibTeX compliant stdClass object
     * with attributes title, year, author, editor, entrytype
     * 
     * If <code>$publication</code> is an instance of <code>BibsonomyPublicationFullBibtex</code>
     * all BibTeX attributes will be mapped.
     * 
     * If an EntrytypeMapper is given, it will be used to convert a given format or category to entrytype otherwise it 
     *
     * @param BibsonomyPublication $publication
     * @param EntrytypeMapper $entrytypeMapper = null
     * @return \stdClass BibTeX compliant stdClass object
     */
    public static function bibsonomyPublication2BibtexStdclass(BibsonomyPublication $publication, EntrytypeMapper $entrytypeMapper = null) {


        $bibtex = new stdClass();

        foreach (self::$stdAttributes as $attr) {

            switch ($attr) {

                case 'bibtexKey':
                    //$bibtex->$attr = $publication->getUniqueID();
                    break;

                case 'author':
                    if ($publication->hasAuthors()) {
                        $bibtex->$attr = SimHashUtils::serializePersonNames($publication->getAuthors());
                    }
                    break;

                case 'editor':
                    if ($publication->hasEditors()) {
                        $bibtex->$attr = SimHashUtils::serializePersonNames($publication->getEditors());
                    }
                    break;

                case 'entrytype':
                    //there is an entrytypeMapper? 
                    if ($entrytypeMapper != null) {
                        //get entrytype from publication
                        $bibtex->$attr = $entrytypeMapper->getEntrytype($publication);
                    } else {
                        //otherwise use entrytype attribute in BibsonomyPublication
                        $bibtex->$attr = self::getValue($publication, $attr);
                    }
                    break;
                case 'title':
                    $bibtex->$attr = $publication->getTitle();
                    break;
                default:
                    if (self::hasValue($publication, $attr)) {
                        $bibtex->$attr = self::getValue($publication, $attr);
                    }
            }
        }

        if ($publication instanceof BibsonomyPublicationFullBibtex) {

            foreach (self::$fullBibtexAttributes as $attr) {

                if (self::hasValue($publication, $attr)) {
                    $bibtex->$attr = self::getValue($publication, $attr);
                }
            }
        }

        return $bibtex;
    }

    private static function hasValue(BibsonomyPublication $object, $property) {


        $functionName = 'get' . strtoupper(substr($property, 0, 1)) . substr($property, 1);

        try {

            $method = new ReflectionMethod($object, $functionName);

            $val = $method->invoke($object);

            return !empty($val);
        } catch (Exception $e) {

            echo "<pre>";
            echo $e->getMessage();
            print_r($e->getTraceAsString());
            echo "</pre>";

            return false;
        }
    }

    private static function getValue(BibsonomyPublication $object, $property) {

        $functionName = 'get' . strtoupper(substr($property, 0, 1)) . substr($property, 1);

        try {

            $method = new ReflectionMethod($object, $functionName);

            return $method->invoke($object);
        } catch (Exception $e) {

            error_log($e->getMessage());
            error_log($e->getTraceAsString());

            return null;
        }
    }

    /**
     * returns an string formatted in BibTeX style
     * @param stdClass $bibtex
     * @param string $prop
     * @param string $value (optional)
     * @return string formatted for BibTeX misc property
     */
    public static function getMiscProp($bibtex, $prop, $value = null) {

        if ($value == null) {
            $value = $bibtex->$prop;
        }

        if (empty($bibtex->misc)) {
            $misc = $prop . " = {" . $value . "}";
        } else {
            $misc = $bibtex->misc . ",\n" . $prop . " = {" . $value . "}";
        }

        return $misc;
    }

    /**
     * 
     * @param stdClass $bibtex
     * @return stdClass $bibtex
     */
    public static function addRequiredFields($bibtex) {
        
        if (empty($bibtex->author) && empty($bibtex->editor)) {
            $bibtex->author = trim('noauthor');
        }
        if (empty($bibtex->year)) {
            $bibtex->year = 'nodate';
        }
        if (empty($bibtex->entrytype)) {
            $bibtex->entrytype = 'misc';
        }
        if (empty($bibtex->title)) {
            $bibtex->title = 'notitle';
        }
        return self::addBibtexKey($bibtex);
    }

    public static function addBibtexKey($bibtex) {

        $authors = $editors = null;
        $aut = preg_split("/" . SimHashUtils::PERSON_NAME_DELIMITER . "/", $bibtex->author);
        $edt = preg_split("/" . SimHashUtils::PERSON_NAME_DELIMITER . "/", $bibtex->editor);

        if (!empty($aut)) {
            $authors = Person::createPersonsListFromArray($aut);
        }
        if (!empty($edt)) {
            $editors = Person::createPersonsListFromArray($edt);
        }

        $bibtex->bibtexKey = self::generateBibtexKey($authors, $editors, $bibtex->year, $bibtex->title);

        return $bibtex;
    }

    /**
     * 
     * @param array<Person> $authors
     * @param array<Person> $editors
     * @param string $year
     * @param string $title
     * @return string
     */
    public static function generateBibtexKey(array $authors, array $editors, $year, $title) {

        /* get author */
        $first = SimHashUtils::getFirstPersonsLastName($authors);
        if ($first == null) {
            $first = SimHashUtils::getFirstPersonsLastName($editors);
            if ($first == null) {
                $first = "noauthororeditor";
            }
        }
        $ret .= strtolower($first);

        /* the year */
        if ($year != null) {
            $ret .= trim($year);
        }

        /* first relevant word of the title */
        if ($title != null) {
            /* best guess: pick first word with more than 4 characters, longest first word */
            // FIXME: what do we want to do inside this if statement?
            $ret .= strtolower(self::getFirstRelevantWord($title));
        }
        
        return preg_replace("![^a-z0-9]!", "", StringUtils::toASCII($ret));
    }

    /**
     * Relevant = longer than four characters (= 0-9a-z)
     * 
     * @param title
     * @return
     */
    public static function getFirstRelevantWord($title) {
        $split = preg_split("!\s!", $title);
        foreach ($split as $s) {
            $ss = preg_replace("[^a-zA-Z0-9]", "", $s);
            if (strlen($ss) > 4) {
                return $ss;
            }
        }
        return "";
    }

    
    public static function limitValueLength(stdClass &$bibtex) {
        
        foreach($bibtex as $key => $val) {
            if(array_key_exists($key, self::$attributeValueLengthLimits)) {
                $len = self::$attributeValueLengthLimits[$key];
                if( strlen($val) > $len ) {
                    $bibtex->$key = substr($val, 0, $len);
                }
            }
        }
    }
}

?>