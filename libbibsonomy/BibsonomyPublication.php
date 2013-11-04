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
 * 
 * A publication, that should be stored in BibSonomy or PUMA, needs at least a 
 * title, a year, the entrytype and authors and/or editors.
 * 
 * To use BibSonomyAPI, your publication model has to implement this Interface.
 * 
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de> 
 */
interface BibsonomyPublication {
    
    
    /**
     * @return boolean
     */
    public function hasAuthors();
    
    /**
     * author: The name(s) of the author(s) 
     * @return array 
     */
    public function getAuthors();

    /**
     * @return boolean
     */
    public function hasEditors();
    
    /**
     * editor: The name(s) of the editor(s) 
     * @return array 
     */
    public function getEditors();

    /**
     * title: The title of the work
     * @return string 
     */
    public function getTitle();

    /**
     * year: The year of publication (or, if unpublished, the year of creation)
     * @return string 
     */
    public function getYear();
    
    /**
     * Bibliography entries are split by types.
     * http://en.wikipedia.org/wiki/BibTeX#Entry_types
     * 
     * @see Entrytype
     * @return string
     */
    public function getEntrytype();
}

?>
