<?php
/**
 *
 *  BibSonomy-Rest-Client - The REST-client.
 *
 *  Copyright (C) 2006 - 2011 Knowledge & Data Engineering Group,
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

require_once 'RESTConfig.php';

/**
 * Use this Class to delete a concept or a single relation.
 * 
 * @author Sebastiam Böttger <boettger@cs.uni-kassel.de>
 */
class DeleteConceptQuery extends DeleteQuery {

    private $conceptName;
    private $grouping;
    private $groupingName;

    /** if is set only the relation <em>conceptName <- subTag </em> will be deleted */
    private $subTag;

    public function __construct($conceptName, $grouping, $groupingName) {
        $this->conceptName = $conceptName;
        $this->grouping = $grouping;
        $this->groupingName = $groupingName;
        $this->downloadedDocument = null;
    }


    protected function query() {

        $this->url = "";

        switch ($this->grouping) {
            case "USER":	
                $this->url = RESTConfig::USERS_URL;
                break;
            case "GROUP":
                $this->url =  RESTConfig::GROUPS_URL;
                break;
            default:
                throw new UnsupportedOperationException("Grouping " . $this->grouping . " is not available for concept delete query");
        }

        $this->url .= "/" . $this->groupingName . "/" . RESTConfig::CONCEPTS_URL . "/" . $this->conceptName;

        if ($this->subTag != null) {
            $this->url .= "?" . RESTConfig::SUB_TAG_PARAM . "=" . $this->subTag;
        }

        return $this->url;
    }


    /**
     * @param subTag the subTag to set
     */
    public function setSubTag($subTag) {
            $this->subTag = $subTag;
    }	
}