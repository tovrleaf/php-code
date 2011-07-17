<?php
/**
* @author Niko Kivelä <niko@tovrleaf.com>
* @since Sun Jun 17 20:42:51 EEST 2011
*/

/**
 * Enchanced version of var_dump
 *
 * Dumps information about a variable similar to var_dump but
 * also uses syntax highlighting for source.
 *
 * @param mixed $expression
 * @return string
 */
function var_dump2()
{
    // can't really use array_map to apply function to all keys in array
    // that would restrict us to call function to all items in array recursively instead of dumping array

    // Turn on output buffering
    ob_start();
    // This function displays structured information about one or more
    // expressions that includes its type and value. Arrays and objects
    // are explored recursively with values indented to show structure.
    $args = func_get_args();

    $out = '';
    foreach ($args as $arg) {
        var_dump($arg);

        // Return the contents of the output buffer
        // Clean (erase) the output buffer and turn off output buffering.
        $out .= ob_get_contents();
        ob_clean();
    }
    ob_end_clean();

    $out = highlight_string('<?php ' . $out . '?>', true);

    // PHP supports eight primitive types.
    $types  = 'bool|int|float|string|'; // scalars
    $types .= 'array|object|';          // compound
    $types .= 'resource|NULL';          // special

    // a lot of flexible regex, if the internal presentation happens to change
    $pattern = '/^(
                    (<([a-z]+)[^>]*>)               # <code>
                    ((<[a-z+][^>]+>\s*)+)           # arbitrary number of tags
                    (<([a-z]+)[^>]+>\s*)            # tag before <?php
                )
                &lt;\?php&nbsp;(
                    (' . $types . ')?               # <?php pseudo-type
                    <\/\\7>.+
                )
                \?&gt;(
                    (<\/[a-z]+[^>]+>\s*)+
                    <\/\\3>                         # end-tag
                )
                $/mxs';
    echo preg_replace($pattern, '\\1\\8\\10', $out);
}
