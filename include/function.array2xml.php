<?php
/**
* @author Niko Kivelä <niko@tovrleaf.com>
* @since Tue Dec 26 17:01:26 EEST 2010
*
* <code>
* // returns
* // <?xml version="1.0" encoding="UTF-8"?>
* // <root><foo>1st</foo><cat>dog</cat><bar><biz>2nd</biz><cruz>3rd</cruz></bar></root>
* $xml = array2xml(array('foo' => '1st', 'cat' => 'dog', 'bar' => array('biz' => '2nd', 'cruz' => '3rd')));
* echo $xml->saveXML();
* </code>
*/

/**
 * Generate xml document from given array recursively
 * @param array $data
 * @param SimpleXMLElement $xml
 * @return SimpleXMLElement
 */
function array2xml(array $data = array(), SimpleXMLElement $xml = null)
{
    if (null === $xml) {
        /* @var $xml SimpleXMLElement */
        $xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><root></root>');
    }
    foreach ($data as $key => $val) {
        // recursion
        is_array($val) ? array2xml($val, $xml->addChild($key)) : $xml->addChild($key, $val);
    }
    return $xml;
}
