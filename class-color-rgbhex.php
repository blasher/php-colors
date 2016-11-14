<?php
/***************************************************************************
 *                                                                         *
 *   class-color-rgbhex.php                                                *
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

if (!class_exists("RGBHexColor"))
{	class RGBHexColor extends Color
	{
		// PHP 5 Constructor
		function __construct($hex_r, $hex_g, $hex_b)
		{	
			$this->redhex   = $hex_r;
			$this->greenhex = $hex_g;
			$this->bluehex  = $hex_b;

			$r = hexdec($hex_r);
			$g = hexdec($hex_g);
			$b = hexdec($hex_b);

			parent::__construct( $r, $g, $b );
		}
	}
}
