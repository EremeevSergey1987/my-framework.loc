<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if($die){
        die;
    }
}

function h($str)
{
    return htmlspecialchars($str);
}

function get_field_value($name)
{
    return isset($_SESSION['form_data'][$name]) ? h($_SESSION['form_data'][$name]) : '';
}

/**
 * @param string $key Key of POST array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
function post($key, $type = 's')
{
    $param = $key;
    $$param = $_POST[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function formatSize($size)
{
    $i = 0;
    while (floor($size / 1024) > 0) {
        ++$i;
        $size /= 1024;
    }

    $size = str_replace('.', ',', round($size, 1));
    switch ($i) {
        case 0: return $size .= ' байт';
        case 1: return $size .= ' КБ';
        case 2: return $size .= ' МБ';
    }
}