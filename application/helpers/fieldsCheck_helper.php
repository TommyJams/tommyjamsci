<?php

function get_key ($haystack, $needle)
{
	$default_value = '';

if (is_array($haystack)) {
// We have an array. Find the key.
        return isset($haystack[$needle]) ? $haystack[$needle] : $default_value;
    }
    else {
     // If it's not an array oit must be an object
     return isset($haystack->$needle) ? $haystack->$needle : $default_value;
    }
}

?>
 