<?php
/***************************************************************************
 *                                                                         *
 *   class-palette.php                                                     *
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

require_once('./class-color.php');

if (!class_exists("Palette"))
{	class Palette
	{
		public $init_color        = array();
		public $monochrome        = array();
		public $complement        = array();
		public $triad             = array();
		public $tetrad            = array();
		public $analogic          = array();
		public $accented_analogic = array();

		// PHP 4 Compatible Constructor
		function Palette($args)
		{	$this->__construct($args);
		}

		// PHP 5 Constructor
		function __construct($args)
		{	$this->args = $args;
			$this->init_color = $args['color'];
		}

		// PHP 5 Constructor
		function init_color()
		{	return $this->init_color;
		}

		function monochrome()
		{	if(!$this->monochrome)
			{	$color1 = $this->init_color();

				$hue = $color1->hue();
				$sat = $color1->sat();
				$lum = $color1->lum();

				// based on colorschemedesigner.com
				$m1 = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue, $sat, $lum ) ) );
				$m2 = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue, $sat + 0.20 , $lum + 0.20 ) ) );
				$m3 = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue, $sat, $lum + 0.40  ) ) );
				$m4 = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue, $sat + 0.40 , $lum ) ) );
				$m5 = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue, $sat, $lum + 0.60 ) ) );

				$this->monochrome = array( $m1, $m2, $m3, $m4, $m5  );
			}
			return $this->monochrome;
		}


		function complement()
		{	if(!$this->complement)
			{	$color1 = $this->init_color();

				// based on colorschemedesigner.com

				// complementary color 
				$complement         = $color1->complement();
				$complement_palette = new Palette( array('color' => $complement ) );

				$monochrome            = $this->monochrome();
				$complement_monochrome = $complement_palette->monochrome();

				$colors = array_merge( $monochrome, $complement_monochrome );
				$this->complement = $colors;
			}
			return $this->complement;
		}


		function triad()
		{	if(!$this->triad)
			{	$color1 = $this->init_color();

				$hue = $color1->hue();
				$sat = $color1->sat();
				$lum = $color1->lum();

				// based on colorschemedesigner.com

				// secondary color a
				$sa         = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue + 0.1666, $sat, $lum ) ) );
				$sa_palette = new Palette( array( 'color' => $sa ) );

				// secondary color b
				$sb         = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue - 0.1666, $sat, $lum ) ) );
				$sb_palette = new Palette( array( 'color' => $sb ) );

				$monochrome    = $this->monochrome();
				$sa_monochrome = $sa_palette->monochrome();
				$sb_monochrome = $sb_palette->monochrome();

				$colors = array_merge( $monochrome, $sa_monochrome, $sb_monochrome );
				$this->triad = $colors;
			}
			return $this->triad;
		}

		function tetrad()
		{	if(!$this->tetrad)
			{	$color1 = $this->init_color();
				$color2 = $color1->complement();

				$hue = $color1->hue();
				$sat = $color1->sat();
				$lum = $color1->lum();

				$c2_hue = $color2->hue();
				$c2_sat = $color2->sat();
				$c2_lum = $color2->lum();

				// based on colorschemedesigner.com

				// secondary color a
				$sa         = $color2;
				$sa_palette = new Palette( array( 'color' => $sa ) );

				// secondary color b
				$sb         = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue + 0.1666, $sat, $lum ) ) );
				$sb_palette = new Palette( array( 'color' => $sb ) );

				// secondary color c
				$sc         = new Color( array( 'type' => 'HSLArray', 'value' => array( $c2_hue + 0.1666 , $c2_sat, $c2_lum ) ) );
				$sc_palette = new Palette( array( 'color' => $sc ) );

				$monochrome    = $this->monochrome();
				$sa_monochrome = $sa_palette->monochrome();
				$sb_monochrome = $sb_palette->monochrome();
				$sc_monochrome = $sc_palette->monochrome();

				$colors = array_merge( $monochrome, $sa_monochrome, $sb_monochrome, $sc_monochrome );
				$this->tetrad = $colors;
			}
			return $this->tetrad;
		}

		function analogic()
		{	if(!$this->analogic)
			{	$color1 = $this->init_color();

				$hue = $color1->hue();
				$sat = $color1->sat();
				$lum = $color1->lum();

				// based on colorschemedesigner.com

				// secondary color a
				$sa         = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue + 0.1666, $sat, $lum ) ) );
				$sa_palette = new Palette( array( 'color' => $sa ) );

				// secondary color b
				$sb         = new Color( array( 'type' => 'HSLArray', 'value' => array( $hue - 0.1666, $sat, $lum ) ) );
				$sb_palette = new Palette( array( 'color' => $sb ) );


				$monochrome    = $this->monochrome();
				$sa_monochrome = $sa_palette->monochrome();
				$sb_monochrome = $sb_palette->monochrome();

				$colors = array_merge( $monochrome, $sa_monochrome, $sb_monochrome );
				$this->analogic = $colors;
			}
			return $this->analogic;
		}


		function accented_analogic()
		{	if(!$this->accented_analogic)
			{	$color1 = $this->init_color();
				$color2 = $color1->complement();

				$colors = array_merge( $this->analogic(), $this->complement() );
				$this->accented_analogic = $colors;
			}
			return $this->accented_analogic;
		}


		function get_colors($type)
		{
			switch( (string) $type )
			{
				case 'monochrome':
					$colors = $this->monochrome();
					break;
				case 'complement':
					$colors = $this->complement();
					break;
				case 'triad':
					$colors = $this->triad();
					break;
				case 'tetrad':
					$colors = $this->tetrad();
					break;
				case 'analogic':
					$colors = $this->analogic();
					break;
				case 'accented analogic':
					$colors = $this->accented_analogic();
					break;
				default:				
					die('Invalid Palette Type: supported at this time: monochrome, complement, triad, tetrad, analogic, accented analogic');
			}
			return $colors;
		}

		function show($type)
		{
			$colors = $this->get_colors($type);
			$return = '<div class="palette">';

			foreach ($colors as $color)
			{
				$return .= $color->sample();
			}
			$return .= '</div>';

			echo $return;
			return $return;
		}



	} // end class Color
} // end if class exists Color

?>