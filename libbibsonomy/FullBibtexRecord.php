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


require_once 'BibsonomyPublicationFullBibtex.php';
require_once 'SimpleRecord.php';

/**
 * Description of FullBibtexRecord
 *
 * @author sebastian
 */
class FullBibtexRecord extends SimpleRecord implements BibsonomyPublicationFullBibtex {
    
    private $abstract;
    
    private $address;
    
    private $annote;

    private $booktitle;
    
    private $chapter;
    
    private $crossref;
    
    private $edition;
    
    private $howpublished;

    private $institution;
    
    private $isbn;
    
    private $issn;
    
    private $journal;

    private $month;
    
    private $note;
    
    private $number;
    
    private $organization;
    
    private $pages;
    
    private $privnote;
    
    private $publisher;
    
    private $school;
    
    private $series;
    
    private $url;
    
    private $volume;
    
    function __construct($title, $year, $authors, $editors, $entrytype, $abstract, $address, $annote, $booktitle, $chapter, $crossref, $edition, $howpublished, $institution, $isbn, $issn, $journal, $month, $note, $number, $organization, $pages, $privnote, $publisher, $school, $series, $url, $volume) {
        
        parent::__construct($title, $year, $authors, $editors, $entrytype);
        
        $this->abstract = $abstract;
        $this->address = $address;
        $this->annote = $annote;
        $this->booktitle = $booktitle;
        $this->chapter = $chapter;
        $this->crossref = $crossref;
        $this->edition = $edition;
        $this->howpublished = $howpublished;
        $this->institution = $institution;
        $this->isbn = $isbn;
        $this->issn = $issn;
        $this->journal = $journal;
        $this->month = $month;
        $this->note = $note;
        $this->number = $number;
        $this->organization = $organization;
        $this->pages = $pages;
        $this->privnote = $privnote;
        $this->publisher = $publisher;
        $this->school = $school;
        $this->series = $series;
        $this->url = $url;
        $this->volume = $volume;

    }

    
    
    public function getAbstract() {
        return $this->abstract;
    }

    public function setAbstract($abstract) {
        $this->abstract = $abstract;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getAnnote() {
        return $this->annote;
    }

    public function setAnnote($annote) {
        $this->annote = $annote;
    }

    public function getBooktitle() {
        return $this->booktitle;
    }

    public function setBooktitle($booktitle) {
        $this->booktitle = $booktitle;
    }

    public function getChapter() {
        return $this->chapter;
    }

    public function setChapter($chapter) {
        $this->chapter = $chapter;
    }

    public function getCrossref() {
        return $this->crossref;
    }

    public function setCrossref($crossref) {
        $this->crossref = $crossref;
    }

    public function getHowpublished() {
        return $this->howpublished;
    }

    public function setHowpublished($howpublished) {
        $this->howpublished = $howpublished;
    }

    public function getInstitution() {
        return $this->institution;
    }

    public function setInstitution($institution) {
        $this->institution = $institution;
    }

    public function getIsbn() {
        return $this->isbn;
    }

    public function setIsbn($isbn) {
        $this->isbn = $isbn;
    }

    public function getIssn() {
        return $this->issn;
    }

    public function setIssn($issn) {
        $this->issn = $issn;
    }

    public function getJournal() {
        return $this->journal;
    }

    public function setJournal($journal) {
        $this->journal = $journal;
    }

    public function getMonth() {
        return $this->month;
    }

    public function setMonth($month) {
        $this->month = $month;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function getPages() {
        return $this->pages;
    }

    public function setPages($pages) {
        $this->pages = $pages;
    }

    public function getPrivnote() {
        return $this->privnote;
    }

    public function setPrivnote($privnote) {
        $this->privnote = $privnote;
    }

    public function getPublisher() {
        return $this->publisher;
    }

    public function setPublisher($publisher) {
        $this->publisher = $publisher;
    }

    public function getSchool() {
        return $this->school;
    }

    public function setSchool($school) {
        $this->school = $school;
    }

    public function getSeries() {
        return $this->series;
    }

    public function setSeries($series) {
        $this->series = $series;
    }


    public function setTitle($title) {
        $this->title = $title;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getVolume() {
        return $this->volume;
    }

    public function setVolume($volume) {
        $this->volume = $volume;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function hasAbstract() {
        return !empty($this->abstract);
    }

    public function hasAddress() {
        return !empty($this->address);
    }

    public function hasAnnote() {
        return !empty($this->annote);
    }

    public function hasBooktitle() {
        return !empty($this->booktitle);
    }

    public function hasChapter() {
        return !empty($this->chapter);
    }

    public function hasCrossref() {
        return !empty($this->crossref);
    }

    public function hasEdition() {
        return !empty($this->edition);
    }

    public function hasHowpublished() {
        return !empty($this->howpublished);
    }

    public function hasInstitution() {
        return !empty($this->institution);
    }

    public function hasIsbn() {
        return !empty($this->isbn);
    }

    public function hasIssn() {
        return !empty($this->issn);
    }

    public function hasJournal() {
        return !empty($this->journal);
    }

    public function hasMonth() {
        return !empty($this->month);
    }

    public function hasNote() {
        return !empty($this->note);
    }

    public function hasNumber() {
        return !empty($this->number);
    }

    public function hasOrganization() {
        return !empty($this->organisation);
    }

    public function hasPages() {
        return !empty($this->pages);
    }

    public function hasPrivnote() {
        return !empty($this->privnote);
    }

    public function hasPublisher() {
        return !empty($this->publisher);
    }

    public function hasSchool() {
        return !empty($this->school);
    }

    public function hasSeries() {
        return !empty($this->series);
    }

    public function hasUrl() {
        return !empty($this->url);
    }

    public function hasVolume() {
        return !empty($this->volume);
    }

    public function getEdition() {
        return $this->edition;
    }

    public function getOrganization() {
        return $this->organization;
    }

    public function getBibtexAbstract() {
        return $this->abstract;
    }

    public function hasBibtexAbstract() {
        return !empty($this->abstract);
    }


}

?>
