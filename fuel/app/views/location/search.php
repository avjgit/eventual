<?php
/**
 * Generating a json structure from location list
 * format as specified in Jquery UI autocomplete:
 * http://api.jqueryui.com/autocomplete/#option-source
 */

$results = array();
foreach ($locations as $location) {
    $results[]= '{"id":"'.addslashes($location->id).'",'.
		'"label":"'.addslashes($location->title).'",'.
		'"value":"'.addslashes($location->title).'"}';
}
echo '['. join(",",$results) .']';
