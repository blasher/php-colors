<?php

require_once( dirname(__FILE__) . '/class-color.php' );

$color1 = new Color( 255, 255, 255 );
echo 'COLOR 1' ."\n";
echo '===================================' . "\n";
$color1->dump();


$color2 = new Color( 32, 32, 32 );
echo 'COLOR 2' ."\n";
echo '===================================' . "\n";
$color2->dump();


$color3 = new Color( 255, 63, 63 );
echo 'COLOR 3' ."\n";
echo '===================================' . "\n";
$color3->dump();


$color4 = new Color( 63, 255, 63 );
echo 'COLOR 4' ."\n";
echo '===================================' . "\n";
$color4->dump();
