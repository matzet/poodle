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
 * Downloads a document for a specific post.
 * 
 * @author Waldemar Biller <wbi@cs.uni-kassel.de>
 * @version $Id: GetPostDocumentQuery.java,v 1.12 2013-03-13 10:45:48 jil Exp $
 */
class GetPostDocumentQuery extends AbstractQuery {


    private $resourceHash;
        
    private $fileName;

	
            /**
     * Gets bibsonomy's posts list.
     * 
     * @param start
     *            start of the list
     * @param end
     *            end of the list
     */
    public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $username, $resourceHash, $fileName) {

        parent::__construct($apiHostUrl, $accessor, $username);

        if (empty($this->username)) throw new IllegalArgumentException("no username given");
        if (empty($this->resourceHash)) throw new IllegalArgumentException("no resourceHash given");
        if (empty($this->fileName)) throw new IllegalArgumentException("no file name given");
                
        $this->resourceHash = $resourceHash;
        
        $this->fileName = $fileName;
        
    }
        

    
    protected function doExecute() {
        
        $client = $this->accessor->getClient();
        
        $url = $this->apiHostUrl . "/" . RESTConfig::USERS_URL . "/" . $this->username . "/posts/" . $this->resourceHash . "/documents/" . $this->fileName;
        
        //$client->
              
        //$this->performFileDownload();
            
               
    }
        
    public function performFileDownload($fileHandle) {
        $meta_data = stream_get_meta_data($fp);
        foreach ($meta_data['wrapper_data'] as $response) {

            /* Were we redirected? */
            if (strtolower(substr($response, 0, 10)) == 'location: ') {

            }
        }


        while(!feof($fileHandle)) {
            print(fread($fh, $fileSize)); 
        } 
    }
}
