<?php
/**
 * Calculate array depth (dimension)
 *
 * Uses textual presentation of array instead of looping through it so there's
 * no consern that if array has reference to itself function will loop infinite
 * (in case of recursion).
 *
 * @code
 * // returns 2
 * echo array_depth(array(1, 2, array(2)));
 * @code
 *
 * @param array $arr  Input array, return its dimension
 * @return int   Depth of array
 */
function array_depth(array $arr)
{
    $depth = function (&$max)
    {
        return function($line) use (&$max)
        {
            $max = max(array($max, (strlen($line) - strlen(ltrim($line))) / 4));
        };
    };
    array_map($depth($max), explode(PHP_EOL, print_r($arr, true)));
    return ceil(($max - 1) / 2) + 1;
}
