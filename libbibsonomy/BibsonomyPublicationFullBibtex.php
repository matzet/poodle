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

require_once __DIR__.'/BibsonomyPublication.php';

/**
 * 
 * A publication, that should be stored in BibSonomy or PUMA, based on BibTeX 
 * standard. This interface provides all methods for information that can be 
 * stored as publication in BibSonomy/PUMA.
 *  
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de> 
 */
interface BibsonomyPublicationFullBibtex extends BibsonomyPublication {
    
    /**
     * @return boolean
     */
    public function hasBibtexAbstract();
    
    /**
     * @return string
     */
    public function getBibtexAbstract();
    
    /**
     * @return boolean
     */
    public function hasAddress();
    
    /**
     * address: Publisher's address (usually just the city, but can be the full 
     * address for lesser-known publishers)
     * @return string
     */
    public function getAddress();
    
    /**
     * @return boolean
     */
    public function hasAnnote();
    
    /** 
     * annote: An annotation for annotated bibliography styles (not typical)
     * @return string
     */
    public function getAnnote();
    
    /**
     * @return boolean
     */
    public function hasBooktitle();
    
    /**
     * booktitle: The title of the book, if only part of it is being cited
     * @return string
     */
    public function getBooktitle();
    
    /**
     * @return boolean
     */
    public function hasChapter();
    
    /**
     * chapter: The chapter number
     * @return string
     */
    public function getChapter();
    
    /**
     * @return boolean
     */
    public function hasCrossref();
    
    /**
     * crossref: The key of the cross-referenced entry
     * @return string
     */
    public function getCrossref();

    /**
     * @return boolean
     */    
    public function hasEdition();
    
    /**
     * edition: The edition of a book, long form (such as "First" or "Second")
     * @return string
     */
    public function getEdition();

    /**
     * @return boolean
     */
    public function hasHowpublished();
    
    /**
     * howpublished: How it was published, if the publishing method is 
     * nonstandard
     * @return string
     */
    public function getHowpublished();
    
    /**
     * @return boolean
     */
    public function hasInstitution();
    
    /**
     * institution: The institution that was involved in the publishing, but not 
     * necessarily the publisher
     * @return string
     */
    public function getInstitution();
    
    /**
     * @return boolean
     */
    public function hasIsbn();
    
    /**
     * ISBN: International Standard Book Number – not a regular part of BibTeX
     * standard. (Saved in misc-field of BibSonomy Publication)
     * @return string
     */
    public function getIsbn();
    
    /**
     * @return boolean
     */
    public function hasIssn();
    
    /**
     * ISSN: International Standard Serial Number – not a regular part of BibTeX
     * standard. (Saved in misc-field of BibSonomy Publication)
     * @return string
     */
    public function getIssn();
    
    
    /**
     * @return boolean
     */
    public function hasJournal();
    
    /** 
     * journal: The journal or magazine the work was published in
     * @return string
     */
    public function getJournal();
    
    /**
     * @return boolean
     */
    public function hasNote();
    
    /**
     * note: Miscellaneous extra information
     * @return string
     */
    public function getNote();
    
    /**
     * @return boolean
     */
    public function hasNumber();
    
    /**
     * number: The "(issue) number" of a journal, magazine, or tech-report, if 
     * applicable. (Most publications have a "volume", but no "number" field.)
     * @return string
     */
    public function getNumber();
    
    /**
     * @return boolean
     */
    public function hasMonth();
    
    /**
     * month: The month of publication (or, if unpublished, the month of creation)
     * @return string
     */
    public function getMonth();
    
    /**
     * @return boolean
     */
    public function hasOrganization();
    
    /**
     * organization: The conference sponsor
     * @return string
     */
    public function getOrganization();
    
    /**
     * @return boolean
     */
    public function hasPages();
    
    /**
     * pages: Page numbers, separated either by commas or double-hyphens.
     * @return string
     */
    public function getPages();
    
    /**
     * @return boolean
     */
    public function hasPrivnote();
    
    /**
     * @return string
     */
    public function getPrivnote();

    /**
     * @return boolean
     */
    public function hasPublisher();
    
    /**
     * publisher: The publisher's name
     * @return string
     */
    public function getPublisher();
    
    /**
     * @return boolean
     */
    public function hasSchool();
    
    /**
     * school: The school where the thesis was written
     * @return string
     */
    public function getSchool();

    /**
     * @return boolean
     */
    public function hasSeries();
    
    /**
     * series: The series of books the book was published in (e.g. 
     * "The Hardy Boys" or "Lecture Notes in Computer Science")
     * @return string
     */
    public function getSeries();
    
    /**
     * @return boolean
     */
    public function hasUrl();
    
    /** 
     * url: The WWW address
     * @return string
     */
    public function getUrl();
    
    /**
     * @return boolean
     */
    public function hasVolume();
    
    /**
     * volume: The volume of a journal or multi-volume book
     * @return string
     */
    public function getVolume();

    
}

?>
