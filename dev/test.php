<?php

// put here test code

$text = Apretaste::cleanText(html_entity_decode("&aacute;", ENT_COMPAT, 'ISO-8859-1'));

var_dump(Apretaste::isUTF8($text));

echo $text;
