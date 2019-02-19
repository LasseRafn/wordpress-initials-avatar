<?php

function hsl2rgb($H, $S, $V) {
    $H *= 6;
    $h = intval($H);
    $H -= $h;
    $V *= 255;
    $m = $V*(1 - $S);
    $x = $V*(1 - $S*(1-$H));
    $y = $V*(1 - $S*$H);
    $a = [[$V, $x, $m], [$y, $V, $m],
          [$m, $V, $x], [$m, $y, $V],
          [$x, $m, $V], [$V, $m, $y]];
    $a = $a[$h];
    return sprintf("%02X%02X%02X", $a[0], $a[1], $a[2]);
}

function hue($tstr) {
    return unpack('L', hash('adler32', $tstr, true))[1];
}

function colorFromText($text) {
    return hsl2rgb(hue($text)/0xFFFFFFFF, 0.5, 1);
} 
