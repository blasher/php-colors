<?php
/***************************************************************************
 *                                                                         *
 *   class-color.php                                                       *
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

if (!class_exists('Color'))
{
	class Color
	{
		public $red        = '';        // dec value 0-255
		public $blue       = '';        // dec value 0-255
		public $green      = '';        // dec value 0-255

		public $rgb        = array();   // array( red, blue, green )

		public $redhex     = '';        // hex value 00-ff
		public $bluehex    = '';        // hex value 00-ff
		public $greenhex   = '';        // hex value 00-ff

		public $rgbhex     = array();   // array( redhex, bluehex, greenhex )
		public $rgbhexstr  = '';

		public $redval     = '';        // normalized value 0.00 - 1.00
		public $blueval    = '';        // normalized value 0.00 - 1.00
		public $greenval   = '';        // normalized value 0.00 - 1.00

		public $var_min    = '';
		public $var_max    = '';
		public $max_delta  = '';

		public $hue        = '';        // normalized value 0.00 - 1.00 (represents 0' - 360')
		public $sat        = '';        // 0-1 (represents 0-100%)
		public $lum        = '';        // 0-1 (represents 0-100%)

		public $hsl        = array();   // array( hue, sat, lum )

		// PHP 5 Constructor
		function __construct( $r, $g, $b )
		{	
			$this->red   = $r;
			$this->green = $g;
			$this->blue  = $b;

			$this->hue   = $this->hue();
			$this->sat   = $this->sat();
			$this->lum   = $this->lum();

			$this->hsl   = $this->hsl();

		}

		///////////////////////////////////////////////
		// RGB FUNCTIONS
		///////////////////////////////////////////////

		function red()
		{
			return $this->red;
		}

		function green()
		{
			return $this->green;
		}

		function blue()
		{
			return $this->blue;
		}

		function rgb()
		{
			return array( $this->red, $this->green, $this->blue );
		}

		function redhex()
		{	if(!$this->redhex)
			{	$this->redhex = dechex( $this->red );
			}
			return $this->redhex;
		}

		function greenhex()
		{	if(!$this->greenhex)
			{	$this->greenhex = dechex( $this->green );
			}
			return $this->greenhex;
		}

		function bluehex()
		{	if(!$this->bluehex)
			{	$this->bluehex = dechex( $this->blue );
			}
			return $this->bluehex;
		}

		function rgbhex()
		{	if(!$this->rgbhex)
			{
				$this->rgbhex = array( $this->redhex(), $this->greenhex(), $this->bluehex() );
			}
			return $this->rgbhex;
		}

		function rgbhexstr()
		{	if(!$this->rgbhexstr)
			{
				$this->rgbhexstr = $this->redhex(). $this->greenhex(). $this->bluehex();
			}
			return $this->rgbhexstr;
		}

		function redval()
		{	if(!$this->redval)
			{	$this->redval = $this->red / 255;
			}
			return $this->redval;
		}

		function greenval()
		{	if(!$this->greenval)
			{	$this->greenval  = $this->green / 255;
			}
			return $this->greenval;
		}

		function blueval()
		{	if(!$this->blueval)
			{	$this->blueval  = $this->blue / 255;
			}
			return $this->blueval;
		}

		function var_min()
		{	if(!$this->var_min)
			 {	$redval         = $this->redval();
				$greenval       = $this->greenval();
				$blueval        = $this->blueval();
				$this->var_min  = min( $redval, $greenval, $blueval );
			}
			return $this->var_min;
		}

		function var_max()
		{	if(!$this->var_max)
			{	$redval         = $this->redval();
				$greenval       = $this->greenval();
				$blueval        = $this->blueval();
				$this->var_max  = max( $redval, $greenval, $blueval );
			}
			return $this->var_max;
		}

		function max_delta()
		{	if(!$this->max_delta)
			{	$var_min         = $this->var_min();
				$var_max         = $this->var_max();
				$this->max_delta = $var_max - $var_min;
			}
			return $this->max_delta;
		}

		///////////////////////////////////////////////
		// HSL FUNCTIONS
		///////////////////////////////////////////////

		function hsl_modulus($arg)
		{	$tmp = $arg;

			if ($tmp < 0)	{ $tmp += 1;	};
			if ($tmp > 1)	{ $tmp -= 1;	};

			if ($tmp != 1)
			{  $tmp = ( ( ($tmp * 1000) % 1000) / 1000 );
			}
			return $tmp;
		}

		function hue()
		{	if(!$this->hue)
			{	$redval     = $this->redval();
				$greenval   = $this->greenval();
				$blueval    = $this->blueval();

				$var_max    = $this->var_max();
				$var_min    = $this->var_min();
				$max_delta  = $this->max_delta();

				$lum        = $this->lum();

				if ($max_delta === 0)
				{
					$h = 0;
				}
				else
				{
					$delta_r = ((($var_max - $redval  ) / 6) + ($max_delta / 2)) / $max_delta;
					$delta_g = ((($var_max - $greenval) / 6) + ($max_delta / 2)) / $max_delta;
					$delta_b = ((($var_max - $blueval ) / 6) + ($max_delta / 2)) / $max_delta;
				
					if ($redval == $var_max)
					{
					        $h = $delta_b - $delta_g;
					}
					elseif ($greenval == $var_max)
					{
					        $h = (1 / 3) + $delta_r - $delta_b;
					}
					elseif ($blueval == $var_max)
					{
					        $h = (2 / 3) + $delta_g - $delta_r;
					};
				
					if ($h < 0)	{ $h += 1;	};
					if ($h > 1)	{ $h -= 1;	};
				};

				$this->hue  = $h;
			}
			return $this->hue;
		}

		function sat()
		{	if(!$this->sat)
			{	$max_delta  = $this->max_delta();
				$var_min    = $this->var_min();
				$var_max    = $this->var_max();
				$lum        = $this->lum();

				if ($max_delta == 0)
				{
					$s = 0;
				}
				else
				{
					if ($lum < 0.5)
					{
						$s = $max_delta / ($var_max + $var_min);
					}
					else
					{
						$s = $max_delta / (2 - $var_max - $var_min);
					};
				};

				$this->sat = $s;
			}
			return $this->sat;
		}

		function lum()
		{	if(!$this->lum)
			{	$var_min    = $this->var_min();
				$var_max    = $this->var_max();
				$lum        = ($var_max + $var_min) / 2;

				if ($lum < 0)	{ $lum += 1;	};
				if ($lum > 1)	{ $lum -= 1;	};

				$this->lum  = $lum;
			}
			return $this->lum;
		}

		function hsl()
		{
			return array( $this->hue, $this->sat, $this->lum );
		}

		///////////////////////////////////////////////
		// CHROMATIC FUNCTIONS
		///////////////////////////////////////////////

		function complement()
		{	$hue = $this->hue();
			$sat = $this->sat();
			$lum = $this->lum();

			$comp_hue = $hue + .5;
			$complement = new Color( array( 'type' => 'HSL',  'value' => array($comp_hue, $sat, $lum) ) );

			return( $complement );
		}

		///////////////////////////////////////////////
		// UTILITY FUNCTIONS
		///////////////////////////////////////////////

		function sample()
		{	if( $this->lum < 0.33)  { $text = '#ffffff'; }
			else                    { $text = '#000000'; }

			return ( '<div class="sample" style="'.
							'background-color:' . $this->rgbhex . '; ' .
							'color: ' . $text .';">' . $this->rgbhex . '<div>' . $this->dump() . '</div></div>' . "\n" );
		}

		function dump()
		{
			print_r($this);
			print "\n\n\n";
		}

		function dump2()
		{
			$return = '';
			$return .= ( '<div class="color dump" style="clear:both">' . "\n" );
			$return .= ( '<pre>' . "\n" );
			$return .= ( 'rgbhex      '.  sprintf("%", $this->rgbhex() ) . "\n" );

			$return .= ( 'redhex      '.  $this->redhex() . "\n" );
			$return .= ( 'bluehex     '.  $this->bluehex() . "\n" );
			$return .= ( 'greenhex    '.  $this->greenhex() . "\n" );

			$return .= ( 'redval      '.  sprintf("%1\$.3f", $this->redval() ) . "\n" );
			$return .= ( 'blueval     '.  sprintf("%1\$.3f", $this->blueval() ) . "\n" );
			$return .= ( 'greenval    '.  sprintf("%1\$.3f", $this->greenval() ) . "\n" );

			$return .= ( 'var_min     '.  sprintf("%1\$.3f", $this->var_min() ) . "\n" );
			$return .= ( 'var_max     '.  sprintf("%1\$.3f", $this->var_max() ) . "\n" );
			$return .= ( 'max_delta   '.  sprintf("%1\$.3f", $this->max_delta() ) . "\n" );

			$return .= ( 'hue         '.  sprintf("%1\$.3f", $this->hue() ) . "\n" );
			$return .= ( 'sat         '.  sprintf("%1\$.3f", $this->sat() ) . "\n" );
			$return .= ( 'lum         '.  sprintf("%1\$.3f", $this->lum() ) . "\n" );
			$return .= ( '</pre>' . "\n" );
			$return .= ( '</div>' . "\n" );
			$return .= "\n\n";

			return( $return );
		}

	} // end class Color
} // end if class exists Color
