<?php
/***************************************************************************
 *                                                                         *
 *   class-color-rgbhexstring.php                                          *
 *                                                                         *
 *   Copyright (C) 2011 by Brian Lasher                                    *
 *   me@brianlasher.com                                                    *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 *   This program is distributed in the hope that it will be useful,       *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of        *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
 *   GNU General Public License for more details.                          *
 *                                                                         *
 *   You should have received a copy of the GNU General Public License     *
 *   along with this program; if not, write to the                         *
 *   Free Software Foundation, Inc.,                                       *
 *   59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             *
 ***************************************************************************/

require_once( dirname(__FILE__) . '/class-color.php' );

if (!class_exists("RGBHexStringColor"))
{	class RGBHexStringColor extends Color
	{
		// PHP 5 Constructor
		function __construct($color_string)
		{	
			$this->color_string = $color_string;

			$pattern     = '/\#/';
			$replacement = '';
			$color_string = preg_replace($pattern, $replacement, $color_string);

			$this->redhex   = substr($color_string,0,2);
			$this->greenhex = substr($color_string,2,2);
			$this->bluehex  = substr($color_string,4,2);

			$r = hexdec($this->redhex);
			$g = hexdec($this->greenhex);
			$b = hexdec($this->bluehex);

			parent::__construct( $r, $g, $b );

		}
	}
}
