<?php
/**
 * @author Niko Kivelä <niko@tovrleaf.com>
 * @since Wes Nov 30 07:24:03 EEST 2011
 *
 * <code>
 * // returns 2
 * class Foo
 * {
 *     private $_id;
 *
 *     public function __construct($id)
 *     {
 *         $this->_id = $id;
 *     }
 *
 *     public function getId()
 *     {
 *         return $this->_id;
 *     }
 * }
 *
 * $arr = array(
 *     new Foo(7),
 *     new Foo(11),
 * );
 *
 * // prints Array ( [0] => 7 [1] => 11 )
 * print_r(array_map_method($arr, 'getId'));
 * </code>
 */

/**
* Create array from values that can be retrieved by object method
*
* Takes array of objects and call user given method for all of them.
* All values are placed in single dimension array.
*
* @param array $array Array of object
* @return array
*/
function array_map_method(array $array, $method)
{
    $f = function(& $container, $method) {
        return function($object) use (& $container, $method) {
            if (is_object($object) && method_exists($object, $method)) {
                $container[] = $object->$method();
            }
        };
    };
    array_map($f($container, $method), $array);
    return $container;
}
