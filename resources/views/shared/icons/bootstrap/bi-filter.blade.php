<?php
$width = $width ?? '16';
$height = $height ?? '16';
$fill = $fill ?? 'currentColor';
$class = 'bi bi-info-circle-fill ' . ($class ?? '');
$onclick = $onclick ?? '';

$attributes = [
    'width' => $width,
    'height' => $height,
    'fill' => $fill,
    'class' => $class,
    'viewbox' => '0 0 ' . $width . ' ' . $height,
];
if ($onclick != "") {
    $attributes['onclick'] = $onclick;
}
?>
<svg xmlns="http://www.w3.org/2000/svg" <?= \Sinevia\Cms\Helpers\CmsHelper::arrayToHtmlAttributes($attributes) ?>>
    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
</svg>
