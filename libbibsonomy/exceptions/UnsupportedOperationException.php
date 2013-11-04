<?php

/**
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

require_once __DIR__.'/BibsonomyException.php';

/**
 * Description of UnsupportedOperationException
 *
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class UnsupportedOperationException extends BibsonomyException {
    
    /**
     * 
     * @param string $message
     * @param integer $code
     */
    public function __construct($message, $code = 0) {
        
        parent::__construct($message, $code);
    }

}

?>