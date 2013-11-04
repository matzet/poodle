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
require_once __DIR__ . '/../AbstractQuery.php';

/**
 * Use this Class to create a new concept
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 * @version $Id: CreateConceptQuery.java,v 1.10 2012-01-20 11:36:10 folke Exp $
 */
class CreateConceptQuery extends AbstractQuery {

    private $concept;
    private $conceptName;
    private $grouping;
    private $groupingName;

    /**
     * 
     * In BibSonomy, a relation consists of two tags, SUBTAG -> SUPERTAG. On 
     * the relations-page you'll find e. g. the following relation: 
     * 'algebra' -> 'mathematics'. It means that 'mathematics' is the supertag 
     * (also called a concept) of 'algebra', and the relation could be read as 
     * 'algebra is a subdiscipline of mathematics'.
     * 
     * You can create relations with this query. Therefor the
     * <code>$concept</code> variable needs to be in a specified structure
     * 
     * <pre>
     * $concept->tag->name
     *              ->globalcount
     *              ->usercount
     *              ->href
     *              ->subtags 
     *                  [0]->tag
     *                      [0] ->name
     *                          ->globalcount
     *                          ->usercount
     *                          ->href
     *                      [1] ->name
     *                          ->globalcount
     *                          ->usercount
     *                          ->href
     *                      ...
     *              ->supertags
     *                  [0]->tag
     *                      [0] ->name
     *                          ->globalcount
     *                          ->usercount
     *                          ->href
     *                      [1] ->name
     *                          ->globalcount
     *                          ->usercount
     *                          ->href
     * </pre>
     * 
     * Note: globalcount, usercount, href are optional attributes! You can also 
     * define only supertags or only subtags.
     * 
     * This complicate object structure is necessary, because of
     * <code>json_encode</code> has to create a JSON object which is expected 
     * by the API.
     * 
     * @param string apiHostUrl
     * @param AuthenticationAccessor $accessor
     * @param stdClass $concept / tag
     * @param string $conceptName
     * @param string $grouping
     * @param string $groupingName
     */
    public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $concept, $conceptName, $grouping, $groupingName) {
        
        parent::__construct($apiHostUrl, $accessor);
        
        $this->concept = $concept;
        $this->conceptName = $conceptName;
        $this->grouping = $grouping;
        $this->groupingName = $groupingName;
    }

    protected function doExecute() {

        $client = $this->accessor->getClient();

        $url = "";
        
        switch ($this->grouping) {
            case Grouping::USER:
                $url = RESTConfig::USERS_URL;
                break;
            case Grouping::GROUP:
                $url = RESTConfig::URL_GROUPS;
                break;
            default:
                throw new UnsupportedOperationException("Grouping " + $this->grouping + " is not available for create concept query");
        }

        $url = $this->apiHostUrl . "/" . $url . "/" . $this->groupingName . "/" . RESTConfig::CONCEPTS_URL . "/" . $this->conceptName;

        $client->setMethod(Zend_Http_Client::POST);
        $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        $client->setHeaders('Accept', 'application/json;charset=UTF-8');
        echo "$url\n";
        
        $client->setUri($url);
        $jsonConcept = json_encode($this->concept);
        print_r($jsonConcept);
        $client->setRawData($jsonConcept);

        $this->response = $client->request();
        $this->result = json_decode($this->response->getBody());
    }

    public function getResult() {
        if($this->response->isSuccessful()) {
            
            return $this->result;
        }
        return $this->getError();
    }

}

?>