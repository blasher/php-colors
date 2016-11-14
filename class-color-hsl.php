<?php
/***************************************************************************
 *                                                                         *
 *   class-color-hsl.php                                                   *
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

// expects h(0-1), s(0-1), l(0-1)

if (!class_exists("HSLColor"))
{	class HSLColor extends Color
	{

		// PHP 5 Constructor
		function __construct($h, $s, $l)
		{	
			$this->hue = $h;
			$this->sat = $s;
			$this->lum = $l;
			$this->hsl = array($h, $s, $l);

			$rgbarray = $this->hsl_2_rgb();

			$r = $rgbarray[0];
			$g = $rgbarray[1];
			$b = $rgbarray[2];

			parent::__construct( $r, $g, $b );

		}

		///////////////////////////////////////////////
		// CONVERSION FUNCTIONS
		///////////////////////////////////////////////

		function hsl_2_rgb()
		{
			$h = $this->hue();
			$s = $this->sat();
			$l = $this->lum();

			if ($s == 0)
			{
				$r = $l * 255;
				$g = $l * 255;
				$b = $l * 255;
			}
			else
			{
				if ($l < 0.5)
				{
					$var_2 = $l * (1 + $s);
				}
				else
				{
					$var_2 = ($l + $s) - ($s * $l);
				}
				
				$var_1 = 2 * $l - $var_2;

				$this->hsl_var_1 = $var_1;
				$this->hsl_var_2 = $var_2;

				$r = round( 255 * $this->hue_2_channel($var_1, $var_2, $h + (1 / 3)) );
				$g = round( 255 * $this->hue_2_channel($var_1, $var_2, $h) );
				$b = round( 255 * $this->hue_2_channel($var_1, $var_2, $h - (1 / 3)) );
			};

			return( array( $r, $g, $b ) );
		}

		// Function to convert hue to RGB, called from above

		function hue_2_channel($v1,$v2,$vh)
		{
			if ($vh < 0) {	$vh += 1; }
			if ($vh > 1) {	$vh -= 1; }
			
			if ((6 * $vh) < 1)
			{
				return ($v1 + ($v2 - $v1) * 6 * $vh);
			}
			
			if ((2 * $vh) < 1)
			{
				return ($v2);
			}
			
			if ((3 * $vh) < 2)
			{
				return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
			}
			
			return ($v1);
		}
	}
}
