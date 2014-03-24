<?php

// put here test code

$text = html_entity_decode("&aacute;", ENT_COMPAT, "UTF-8");

var_dump(Apretaste::isUTF8($text));

echo $text;
