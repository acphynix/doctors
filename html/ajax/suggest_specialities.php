<?php
// Array with names

$filename = "../../web_data/specialities.txt";
$listall = file($filename, FILE_IGNORE_NEW_LINES);

// $listall = array("apple","ball");
// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    $numsuggestions = 5;
    foreach($listall as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = "\"" . $name . "\"";
            } else {
                $hint .= ", \"$name\"";
            }
            $numsuggestions -= 1;
        }
        if ($numsuggestions === 0){
            break;
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "[]" : ("[" . $hint . "]");

?>