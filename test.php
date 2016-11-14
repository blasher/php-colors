<?php

require_once( dirname(__FILE__) . '/class-color.php' );
require_once( dirname(__FILE__) . '/class-color-rgb.php' );
require_once( dirname(__FILE__) . '/class-color-rgbhex.php' );
require_once( dirname(__FILE__) . '/class-color-rgbhexstring.php' );

$color1 = new Color( 255, 63, 63 );
echo 'COLOR 1' ."\n";
echo '===================================' . "\n";
$color1->dump();


$color2 = new RGBColor( 63, 255, 63 );
echo 'COLOR 2' ."\n";
echo '===================================' . "\n";
$color2->dump();


$color3 = new RGBHexColor( '80', '40', 'ff' );
echo 'COLOR 3' ."\n";
echo '===================================' . "\n";
$color3->dump();

$color4 = new RGBHexStringColor( '3792f3' );
echo 'COLOR 4' ."\n";
echo '===================================' . "\n";
$color4->dump();

$color5 = new RGBHexStringColor( '#0251ee' );
echo 'COLOR 5' ."\n";
echo '===================================' . "\n";
$color5->dump();
