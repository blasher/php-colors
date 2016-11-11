<?php
/***************************************************************************
 *                                                                         *
 *   class-color.php & class-palette.php examples                          *
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

<?php
require_once('./class-color.php');
require_once('./class-palette.php');
?>

<style>
body
{	font-family: Arial;
}
h1
{	font-size: 16px;
	display: block;
	clear: both;
	margin: 20px 0px;
}
code
{	display: block;
	margin: 10px 10px;
	white-space: pre;
}
.sample
{	display: block;
	position: relative;;
	float: left;
	line-height: 30px;
	text-transform: uppercase;
	text-align: center;
	font-size: 12px;
}
.palette
{	display: block;
	clear: both;
}
.dump
{	display: block;
	text-align: left;
	text-transform: none;
	line-height: 16px;
}
</style>
<h1>COLOR1: RGBString Example</h1>
<code>
	$color1 = new Color( array( 'type' => 'RGBString', 'value' => '33aacc') );
	echo( $color1->sample() );
</code><br />
<?php
	$color1 = new Color( array( 'type' => 'RGBString', 'value' => '33aacc') );
	echo( $color1->sample() );
?>


<h1>COLOR2: RGBArray Example</h1>
<code>
	$color2 = new Color( array( 'type' => 'RGBArray', 'value' => array('33', 'aa', 'cc') ) );
	echo( $color2->sample() );
</code>
<?php
	$color2 = new Color( array( 'type' => 'RGBArray', 'value' => array('33', 'aa', 'cc') ) );
	echo( $color2->sample() );
?>


<h1>COLOR3: HSLArray Example</h1>
<code>
	$color3 = new Color( array( 'type' => 'HSLArray', 'value' => array('0.537', '0.6', '0.5') ) );
	echo( $color3->sample() );
</code>
<?php
	$color3 = new Color( array( 'type' => 'HSLArray', 'value' => array('0.537', '0.6', '0.5') ) );
	echo( $color3->sample() );
?>


<h1>COLOR4: Complement of Color 3 Example</h1>
<code>
	$color4 = $color3->complement();
	echo( $color4->sample() );
</code>
<?php
	$color4 = $color3->complement();
	echo( $color4->sample() );
?>


<h1>COLOR5: Complement of Color 4 Example</h1>
<code>
	$color5  = $color4->complement();
	echo( $color5->sample() );
</code>
<?php
	$color5  = $color4->complement();
	echo( $color5->sample() );
?>


<h1>PALETTE1: Monochrome Palette Example</h1>
<code>
	$palette1 = new Palette( array('color' => $color1 ) );
	$palette1->show('monochrome');
</code>
<?php
	$palette1 = new Palette( array('color' => $color1 ) );
	$palette1->show('monochrome');
?>


<h1>PALETTE2: Complement Palette Example</h1>
<code>
	$palette2 = new Palette( array('color' => $color1 ) );
	$palette2->show('complement');
</code>
<?php
	$palette2 = new Palette( array('color' => $color1 ) );
	$palette2->show('complement');
?>


<h1>PALETTE3: Triad Palette Example</h1>
<code>
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('triad');
</code>
<?php
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('triad');
?>


<h1>PALETTE3: Tetrad Palette Example</h1>
<code>
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('tetrad');
</code>
<?php
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('tetrad');
?>

<h1>PALETTE3: Analogic Palette Example</h1>
<code>
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('analogic');
</code>
<?php
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('analogic');
?>

<h1>PALETTE3: Accented Analogic Palette Example</h1>
<code>
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('accented analogic');
</code>
<?php
	$palette3 = new Palette( array('color' => $color1 ) );
	$palette3->show('accented analogic');
?>






