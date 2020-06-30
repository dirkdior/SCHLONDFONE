<?php

$auth = $_GET["auth"];

include "alegehMain.php";
include "alegehEnums.php";

if($auth == 200){

    if(date('w') == 1 || date('w') == 2 || date('w') == 3 || date('w') == 4 || date('w') == 5) {

        if(date('H') == "08") {
            pushNotes(Subjects::maths);
            pushNotes(Subjects::english);
            pushNotes(Subjects::business_studies);
            pushNotes(Subjects::basic_science);
            pushNotes(Subjects::civic_education);
            pushNotes(Subjects::history);
            logMsg(
                "INFO",
                "Notes pushed to subscibers at this hour"
            );
        } else
            logMsg(
                "ERROR",
                "Request to push notes at an unspecified hour"
            );
        

    } else {
        logMsg(
            "ERROR",
            "Request to push notes on a day not specified"
        );
        echo "No Note Push today";
    }

} else
    echo "Access Denied! Invalid Authentication.";
