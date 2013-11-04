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


class SimpleEntrytypeMapper extends EntrytypeMapper {
    
    
    protected $entrytypeMap = array(
        'manuscript'        => 'unpublished',
        'ebook'             => 'electronic',
        'book'              => 'book',
        'journal'           => 'periodical',
        'newspaper'         => 'periodical',
        'software'          => 'misc',
        'physicalobject'    => 'misc',
        'cd'                => 'misc',
        'dvd'               => 'electronic',
        'electronic'        => 'electronic',
        'map'               => 'misc',
        'globe'             => 'misc',
        'slide'             => 'presentation',
        'microfilm'         => 'misc',
        'photo'             => 'misc',
        'video'             => 'misc',
        'kit'               => 'misc',
        'musicalscore'      => 'misc',
        'sensorimage'       => 'misc',
        'audio'             => 'misc',
        'retro'             => 'misc'
    );

    public function getEntrytype(BibsonomyPublication $record) {
        $format = $record->getEntrytype();
        return parent::getEntrytype($this->entrytypeMap, $format);
    }

}
?>
