<?php

$width = $width ?? '16';
$height = $height ?? '16';
$fill = $fill ?? 'currentColor';
$class = 'bi ' . ($class ?? '');
$onclick = $onclick ?? '';

$attributes = [
    "xmlns" => "http://www.w3.org/2000/svg",
    'width' => $width,
    'height' => $height,
    'fill' => $fill,
    'class' => $class,
    'viewbox' => '0 0 ' . $width . ' ' . $height,
];

if ($onclick != "") {
    $attributes['onclick'] = $onclick;
}

echo \Sinevia\Cms\Helpers\CmsHelper::arrayToHtmlAttributes($attributes);
