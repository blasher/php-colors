<?php
/***************************************************************************
 *                                                                         *
 *   class-color.php                                                       *
 *   V1.0.000                                                              *
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

if (!class_exists("Color"))
{	class Color
	{
		public $init_type  = '';
		public $init_value = '';

		public $rgbhex     = '';

		public $redhex     = '';
		public $bluehex    = '';
		public $greenhex   = '';

		public $redval     = '';
		public $blueval    = '';
		public $greenval   = '';

		public $var_min    = '';
		public $var_max    = '';
		public $max_delta  = '';

		public $hue        = '';
		public $sat        = '';
		public $lum        = '';

		// PHP 4 Compatible Constructor
		function Color($args)
		{	$this->__construct($args);
		}

		// PHP 5 Constructor
		function __construct($args)
		{	$this->args = $args;

		  switch( (string) $args['type'] )
			{
				case 'RGBString':
					$this->rgbhex   = $args['value'];
					$this->hue      = $this->hue();
					$this->sat      = $this->sat();
					$this->lum      = $this->lum();
					break;
				case 'RGBArray':
					$this->rgbarray = $args['value'];
					$this->rgbhex   = $this->rgbarray[0].$this->rgbarray[1].$this->rgbarray[2];
					$this->hue      = $this->hue();
					$this->sat      = $this->sat();
					$this->lum      = $this->lum();
					break;
				case 'HSLArray':
					$this->hslarray = $args['value'];
					$this->hue      = $this->hsl_modulus( $this->hslarray[0] );
					$this->sat      = $this->hsl_modulus( $this->hslarray[1] );
					$this->lum      = $this->hsl_modulus( $this->hslarray[2] );
					$this->rgbhex   = $this->hsl_2_rgb();
					break;
				default:				
					die('Valid Initial Color Types supported at this time: RGBString, RGBArray, HSLArray');
			}
		}

		function hsl_modulus($arg)
		{	$tmp = $arg;

			if ($tmp < 0)	{ $tmp += 1;	};
			if ($tmp > 1)	{ $tmp -= 1;	};

			if ($tmp != 1)
			{  $tmp = ( ( ($tmp * 1000) % 1000) / 1000 );
			}
			return $tmp;
		}

		function rgbhex()
		{	if(!$this->rgbhex)
			{
			}
			return $this->rgbhex;
		}

		function redhex()
		{	if(!$this->redhex)
			{	$rgbhex         = $this->rgbhex;
				$this->redhex   = substr($rgbhex,0,2);
			}
			return $this->redhex;
		}

		function greenhex()
		{	if(!$this->greenhex)
			{	$rgbhex         = $this->rgbhex;
				$this->greenhex = substr($rgbhex,2,2);
			}
			return $this->greenhex;
		}

		function bluehex()
		{	if(!$this->bluehex)
			{	$rgbhex         = $this->rgbhex;
				$this->bluehex  = substr($rgbhex,4,2);
			}
			return $this->bluehex;
		}

		function redval()
		{	if(!$this->redval)
			 {	$redhex        = $this->redhex();
				$this->redval  = ( hexdec($redhex) ) / 255;
			}
			return $this->redval;
		}

		function greenval()
		{	if(!$this->greenval)
			{	$greenhex        = $this->greenhex();
				$this->greenval  = ( hexdec($greenhex) ) / 255;
			}
			return $this->greenval;
		}

		function blueval()
		{	if(!$this->blueval)
			{	$bluehex        = $this->bluehex();
				$this->blueval  = ( hexdec($bluehex) ) / 255;
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

		function hue()
		{	if(!$this->hue)
			{	$var_max    = $this->var_max();
				$var_min    = $this->var_min();
				$max_delta  = $this->max_delta();
				$lum        = $this->lum();
				$redval     = $this->redval();
				$greenval   = $this->greenval();
				$blueval    = $this->blueval();

				if ($max_delta == 0)
				{
					$h = 0;
				}
				else
				{
					$del_r = ((($var_max - $redval  ) / 6) + ($max_delta / 2)) / $max_delta;
					$del_g = ((($var_max - $greenval) / 6) + ($max_delta / 2)) / $max_delta;
					$del_b = ((($var_max - $blueval ) / 6) + ($max_delta / 2)) / $max_delta;
				
					if ($redval == $var_max)
					{
					        $h = $del_b - $del_g;
					}
					elseif ($greenval == $var_max)
					{
					        $h = (1 / 3) + $del_r - $del_b;
					}
					elseif ($blueval == $var_max)
					{
					        $h = (2 / 3) + $del_g - $del_r;
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
				};
				
				$var_1 = 2 * $l - $var_2;
				$r = 255 * $this->hue_2_rgb($var_1,$var_2,$h + (1 / 3));
				$g = 255 * $this->hue_2_rgb($var_1,$var_2,$h);
				$b = 255 * $this->hue_2_rgb($var_1,$var_2,$h - (1 / 3));
			};

			// And after that routine, we finally have $r, $g and $b in 255 255 255 (RGB) format, which we can convert to six digits of hex:

			$rhex = sprintf("%02X",round($r));
			$ghex = sprintf("%02X",round($g));
			$bhex = sprintf("%02X",round($b));

			return(  $rhex.$ghex.$bhex );
		}

		// Function to convert hue to RGB, called from above

		function hue_2_rgb($v1,$v2,$vh)
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

		function complement()
		{	$hue = $this->hue();
			$sat = $this->sat();
			$lum = $this->lum();

			$comp_hue = $hue + .5;
			$complement = new Color( array( 'type' => 'HSLArray',  'value' => array($comp_hue, $sat, $lum) ) );

			return( $complement );
		}

		function sample()
		{	if( $this->lum < 0.33)  { $text = '#ffffff'; }
			else                    { $text = '#000000'; }

			return ( '<div class="sample" style="'.
							'background-color:' . $this->rgbhex . '; ' .
							'color: ' . $text .';">' . $this->rgbhex . '<div>' . $this->dump() . '</div></div>' . "\n" );
		}

		function dump()
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

			return( $return );
		}




	} // end class Color
} // end if class exists Color

?>