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

/**
 * Use this Class to get information about the specified concept
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class GetConceptDetailsQuery extends AbstractQuery {

    private $conceptname;
    private $groupingValue;
    private $grouping = GroupingEntity::ALL;

    public function __construct($conceptName) {
        $this->conceptname = $conceptName;
        $this->downloadedDocument = null;
    }

    protected function query() {
        $this->url = null;

        switch ($this->grouping) {
            case Grouping::USER:
                $this->url = RESTConfig::USERS_URL . "/" . $this->groupingName . "/" . RESTConfig::CONCEPTS_URL . "/" . $this->conceptname;
                break;
            case Grouping::GROUP:
                throw new UnsupportedOperationException("Grouping " . $this->grouping . " is not implemented yet");
            //url = URL_GROUPS + "/" + this.groupingName + "/" + URL_CONCEPTS + "/" + this.conceptname;
            //break;
            case Grouping::ALL:
                $this->url = RESTConfig::CONCEPTS_URL . "/" . $this->conceptname;
                break;
            default:
                throw new UnsupportedOperationException("Grouping " . $this->grouping . " is not available for concept details query");
        }
    }

    protected function doExecute() {

        $this->query();
        
        $client = $this->accessor->getClient();
        
        $client->setUri(
                Zend_Uri_Http::fromString($this->url)
        );
        
        $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        
        $this->response = $client->request(Zend_Http_Client::GET);
    }

    public function getResult() {
        if ($this->response == null)
            throw new IllegalStateException("Execute the query first.");

        return json_decode($this->response->getBody());
    }

    public function setGroupingUser($userName) {
        $this->groupingName = $userName;
        $this->grouping = Grouping::USER;
    }

    public function setGroupingGroup($groupName) {
        $this->groupingName = $groupName;
        $this->grouping = Grouping::GROUP;
    }

}
