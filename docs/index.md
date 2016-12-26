### Welcome to PHP-Colors

This is an onject oriented php library for manipulating colors.

### Authors and Contributors

Brian Lasher

### Installation

Simply clone the repo and place the library in the appropriate for your project.

### Usage

#### Example 1: Instantiating Colors

```php
require_once('/class-color.php' );
require_once('/class-color-rgb.php' );
require_once('/class-color-rgbhex.php' );
require_once('/class-color-rgbhexstring.php' );
require_once('/class-color-hsl.php' );

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

$color5 = new HSLColor( 0.33, 1.0, 0.66 );
echo 'COLOR 5' ."\n";
echo '===================================' . "\n";
$color5->dump();
```

#### Example 2: Generating Palettes

```php
require_once('/class-color.php' );
require_once('/class-palette.php' );

$palette1 = new Palette( array('color' => $color1 ) );
$palette1->show('monochrome');

$palette2 = new Palette( array('color' => $color1 ) );
$palette2->show('complement');

$palette3 = new Palette( array('color' => $color1 ) );
$palette3->show('triad');

$palette3 = new Palette( array('color' => $color1 ) );
$palette3->show('tetrad');

$palette3 = new Palette( array('color' => $color1 ) );
$palette3->show('analogic');

$palette3 = new Palette( array('color' => $color1 ) );
$palette3->show('accented analogic');
```


### Support or Contact

Having trouble? Contact me at <a href="mailto:me@brianlasher.com">me@brianlasher.com</a> and i will do my best to help you sort it out.
