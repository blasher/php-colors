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

  function force_8bit_value(&$v)
  {
    $v = ($v < 0) ? 0 : (($v > 255) ? 255 : $v);
    return $v;
  }
  
  function rgb2hsl($rgb)
  {
    list($r,$g,$b) = $rgb;
    force_8bit_value($r);
    force_8bit_value($g);
    force_8bit_value($b);
    $min = min($r, min($g, $b));
    $max = max($r, max($g, $b));
    $l = round(($max + $min)/2);
    if($max == $min)
    {
      $h = 160;
      $s = 0;
    }
    else
    {
      if ($l < 128)
        $s = round(255* ($max - $min)/($max + $min));
      else
        $s = round(255 * ($max - $min)/(510 - $max - $min));
      if ($r == $max)
        $h = ($g - $b)/($max - $min);
      else
        if ($g == $max)
          $h = 2 + ($b - $r)/($max - $min);
        else
          $h = 4 + ($r - $g)/($max - $min);
      $h *= 60;
      if ($h < 0)
        $h += 360;
      $h = round($h * 255/360);
    }
    return array($h, $s, $l);
  }

  function make_rgb1($rm1, $rm2, $rh)
  {
    if ($rh > 360)
      $rh -= 360;
    else
      if ($rh < 0)
        $rh += 360;
    if ($rh < 60)
      $rm1 = $rm1 + ($rm2 - $rm1) * $rh / 60;
    else
      if ($rh < 180)
        $rm1 = $rm2;
      else
        if ($rh < 240)
          $rm1 = $rm1 + ($rm2 - $rm1) * (240 - $rh) / 60;
    return round($rm1 * 255);
  }
   
  function hsl2rgb($hsl)
  {
    list($h, $s, $l) = $hsl;
    force_8bit_value($h);
    force_8bit_value($s);
    force_8bit_value($l);
    
    $h = $h * 360 / 255;
    $s /= 255;
    $l /= 255;
    if ($l <= 0.5)
      $rm2 = $l + $l * $s;
    else
      $rm2 = $l + $s - $l * $s;
    $rm1 = 2 * $l - $rm2;
    return array(make_rgb1($rm1, $rm2, $h + 120), make_rgb1($rm1, $rm2, $h), make_rgb1($rm1, $rm2, $h - 120));
  }

  function rgb2html($rgb)
  {
    list($r, $g, $b) = $rgb;
    force_8bit_value($r);
    force_8bit_value($g);
    force_8bit_value($b);
    return "#" . str_pad(dechex($r), 2, "0", STR_PAD_LEFT) . str_pad(dechex($g), 2, "0", STR_PAD_LEFT) . 
      str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
  }

  function hsl2html($hsl)
  {
    return rgb2html(hsl2rgb($hsl));
  }

  function html2rgb($hex)
  {
    $hex = trim($hex);
    if ($hex[0] == "#")
      $h = substr($hex, 1);
    $int = hexdec($hex);    
    return array(0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
  }
  
  function html2hsl($hex)
  {
    return rgb2hsl(html2rgb($hex));
  }

  function get_gradient($start_color, $end_color, $no_steps)
  {
    $arr = array(0=>$start_color);
    $no_steps -= 2;
    $no_steps = ($no_steps > 0) ? $no_steps : 0;
    
    $s_rgb = html2rgb($start_color);
    $e_rgb = html2rgb($end_color);
   
    if ($no_steps > 0)
    { 
      $rstep = ($s_rgb[0] - $e_rgb[0]) / $no_steps;
      $gstep = ($s_rgb[1] - $e_rgb[1]) / $no_steps;
      $bstep = ($s_rgb[2] - $e_rgb[2]) / $no_steps;    
    }
    
    for ($i=0; $i < $no_steps; $i++)
    {
      $s_rgb[0] -= $rstep;
      $s_rgb[1] -= $gstep;
      $s_rgb[2] -= $bstep;
      $arr[] = rgb2html($s_rgb);
    }

    $arr[] = $end_color;
    return $arr;
  }
    
  function gradient($start_color, $end_color, $no_steps, $percent=50)
  {  
    $grad = get_gradient($start_color, $end_color, $no_steps);
    if ($percent == 50 || $no_steps < 6)
      return $grad;
    else
    {
      $percent = ($percent > 100) ? 100 : $percent;
      $percent = ($percent < 1) ? 1 : ($percent / 100);
      $mc_idx = round($no_steps / 2);
      $mc = $grad[$mc_idx];
      $s1 = round($no_steps * $percent);
      $s2 = round($no_steps - $s1);
      
      if ($s2 + 2 > $no_steps)
        $s2 = $no_steps - 2;

      if ($s1 + 2 > $no_steps)
        $s1 = $no_steps - 2;

      $grad1 = get_gradient($start_color, $mc, $s1);
      $grad2 = get_gradient($grad[$mc_idx + 1], $end_color, $s2);
      return array_merge($grad1, $grad2);
    }
  }
  
  function print_color($c)
  {
    echo "($c[0], $c[1], $c[2])<br/>\n";
  }
  
?>
