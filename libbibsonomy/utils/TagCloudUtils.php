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


class TagCloudUtils {
    
    
    /**
     *
     * @param string $tags
     * @param string $targetUrl 
     * @return string rendered TagCloud
     */
    public static function simpleTagCloud($tags, $targetUrl, $min, $max) {
        
        $maxcount = $tags->tags->tag[0]->usercount;
        $out = array();

        foreach($tags->tags->tag as $tag) {


            $count = $tag->usercount;

            $size = ($count/$maxcount)*($max - $min) + $min;

            $out[$tag->name] = '<a href="'.$targetUrl.'?tag='.urlencode($tag->name).'" style="font-size: '.sprintf("%01.2f",$size).'em;">'.$tag->name.'</a> ';
        }
        sort($out);
        $str = "";

        foreach($out as $val) {
            $str .= $val;
        }

        return $str;

    }
}

?>
