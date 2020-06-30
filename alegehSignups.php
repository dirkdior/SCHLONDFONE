<?php

$auth = $_GET["auth"];

if($auth == "XqTs223Sd")
    echo file_get_contents("alegeh/ussdEntry.log");
else
    echo "Nothing to see here";