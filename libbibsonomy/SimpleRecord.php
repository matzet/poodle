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


require_once 'BibsonomyPublication.php';
require_once 'RESTConfig.php';

/**
 * Helper class for SimHashUtilsTest
 */
class SimpleRecord implements BibsonomyPublication {
    protected $title, $year, $authors, $editors, $entrytype;
    public function __construct($title, $year, $authors, $editors, $entrytype=Entrytype::MISC) {
        $this->title=$title;$this->year=$year;$this->authors=$authors;$this->editors=$editors;$this->entrytype=$entrytype;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getYear() {
        return $this->year;
    }
    public function getAuthors() {
        return $this->authors;
    }
    public function getEditors() {
        return $this->editors;
    }
    public function getEntrytype() {
        return $this->entrytype;
    }
    public function hasAuthors() {
        return (!empty($this->authors));
    }
    public function hasEditors() {
        return (!empty($this->editors));
    }
}
?>