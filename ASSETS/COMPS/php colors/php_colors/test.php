<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PHP Colors</title>
</head>

<body>
<?
/***************************************************************************
 *   Copyright (C) 2007 by Jorge del Conde                                 *
 *   jconde@gmail.com                                                      *
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

  require_once("php_colors.inc");

  function tigra()
  {
    echo "<b>Tigra Color Picker:</b><br/>";
    echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding = \"0\">\n";
    for ($j=0; $j<12; $j++)
    {
      echo "<tr>\n";
      for ($k=0; $k<3; $k++)
      {
        for ($i=0; $i<=5; $i++)
        {
          $rgb[0] = $k * 51 + ($j % 2) * 51 * 3;
          $rgb[1] = floor($j / 2) * 51;
          $rgb[2] = $i * 51;
          $col = rgb2html($rgb);
          echo "<td bgcolor=\"$col\">&nbsp;</td>\n";
        }
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  }

  function random_gradient()
  {
    echo "<b>Gradient Demo:</b><br/>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding = \"0\">\n";
    for ($j=0; $j<12; $j++)
    {
      echo "<tr>";
      $c[0] = rand(0, 255);
      $c[1] = rand(0, 255);
      $c[2] = rand(0, 255);
        
      $c2[0] = rand(0, 255);
      $c2[1] = rand(0, 255);
      $c2[2] = rand(0, 255);
      
      if ($j < 4)  // always show some 50% gradients
        $percent = 50;
      else
        $percent = rand(20, 80);
        
      $grad = gradient(rgb2html($c), rgb2html($c2), 30, $percent);
      foreach($grad as $k=>$v)
        echo "<td bgcolor=\"$v\">&nbsp;</td>\n";

      echo "</tr>\n";
    }
    echo "</table>\n";
  }

  function hsl_demo()
  {
    $hsl[0] = rand(0, 255);  // Hue
    $hsl[1] = rand(0, 255);  // Sat
    $hsl[2] = 230;           // Lum
    $lum = rand(0, 180);
    
    $diff = $hsl[2] - $lum;
    $step = $diff / 12;
    $color = hsl2html($hsl);

    echo "<b>HSL Luminosity Demo:</b><br/>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding = \"0\">\n";
    for ($i=0; $i < 12; $i++)
    {
      $hsl = html2hsl($color);
      echo "<tr><td bgcolor=\"$color\">&nbsp;</td>\n</tr>\n";
      $hsl[2] -= $step;
      $color = hsl2html($hsl);
    }
    echo "</table>\n";
  }

  function rgb_demo()
  {
    echo "<b>RGB Demo:</b><br/>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding = \"0\">\n";
    for ($j=0; $j<12; $j++)
    {
      echo "<tr>\n";
      $c[0] = rand(0, 255);
      $c[1] = rand(0, 255);
      $c[2] = rand(0, 255);

      $rstep = rand(-15, 15);
      $gstep = rand(-15, 15);
      $bstep = rand(-15, 15);
        
      for ($i=0; $i<30; $i++)
      {
        $col = rgb2html($c);
        echo "<td bgcolor=\"$col\">&nbsp;</td>\n";
        $c[0] += $rstep;
        $c[1] += $gstep;
        $c[2] += $bstep;
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  }


  function hue_box()
  {
    echo "<b>Hue Box:</b><br/>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding = \"0\">\n";
    echo "<tr>\n";

    $hsl = array();

    $hsl[1] = 255;
    $hsl[2] = 128;
    for ($h = 0; $h < 256; $h += 2)
    {
      $hsl[0] = $h;
      $col = hsl2html($hsl);
      echo "<td bgcolor=\"$col\"><br/>&nbsp;</td>\n";
    }
    echo "</tr>\n";

    echo "<tr>\n";
    $hsl[1] = rand(100, 255);
    $hsl[2] = rand(50, 180);
    for ($h = 255; $h >= 0; $h -= 2)
    {
      $hsl[0] = $h;
      $col = hsl2html($hsl);
      echo "<td bgcolor=\"$col\"><br/>&nbsp;</td>\n";
    }
    echo "</tr>\n";
    echo "</table>\n";
  }

  function gray_scale()
  {
    echo "<b>Gray Scale:</b><br/>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding = \"0\">\n";
    echo "<tr>\n";

    $rgb = array();

    for ($i = 0; $i < 256; $i += 2)
    {
      for ($j = 0; $j < 3; $j++)
        $rgb[$j] = $i;

      $col = rgb2html($rgb);
      echo "<td bgcolor=\"$col\"><br/>&nbsp;</td>\n";
    }
    echo "</tr>\n";
    echo "</table>\n";
  }
  
  echo "<p><font size=\"+2\"><b>PHP Colors</b> demo by Jorge del Conde<br><br>";
  echo "If you have questions or comments, send me an email: <a 
  href=\"mailto:jconde@gmail.com\">jconde@gmail.com</a></font></p>\n";
  
  echo "<p><a href=\"php_colors.tar.gz\">Download <b>PHP Colors</b></a></p>\n";

  echo "<p><b>NOTE:</b> Most of these demos use random colors.  Be sure to reload the page!</p>\n";

  hue_box();  
  echo "<hr/>";

  gray_scale();
  echo "<hr/>";
  
  random_gradient();
  echo "<hr/>";

  hsl_demo();
  echo "<hr/>";

  rgb_demo();  
  echo "<hr/>";
  
  tigra();
  echo "<hr/>";
?>
<div align="center"><a href="http://www.consultaspecialist.com">Consult a Specialist</a></div>
</body>
</html>

