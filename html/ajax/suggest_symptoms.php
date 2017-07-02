<?php
// Array with names
$a[] = "acne";
$a[] = "anxiety";
$a[] = "arrhythmia";
$a[] = "ataxia";
$a[] = "anaphylactic shock";
$a[] = "allergy";
$a[] = "fever";
$a[] = "headache";
$a[] = "foot pain";

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    $numsuggestions = 5;
    foreach($a as $name) {
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