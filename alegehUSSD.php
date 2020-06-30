<?php

include "alegehEnums.php";
include "alegehMain.php";

$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

$newText    = getInput($text);
$steps      = explode("*", $newText);
$count      = count($steps);

$error_menu = "CON Invalid Input, Please try again. \n00. Main Menu";

if ($newText == "") {

    $response = "CON Welcome to EASYRead Ed-Tech Platform.";
    $response .= "\n1. About us";
    $response .= "\n2. Register";
    $response .= "\n3. Contact us";

} else if($count == 1) {

    if ($steps[0] == "1")
        $response = "CON About us: \nSCHLondFone, helps teachers & parents better support their children's learning via curriculum based SMS educational nuggets. \n00. Main Menu";
    
    else if ($steps[0] == "2")
        $response = "CON Enter full name/class/age/sex/location in this format; John Alegeh, JSS2, 11, M, Abuja. \n00. Main Menu";

    else if ($steps[0] == "3")
        $response = "CON About Us \nUSSD: *347*133# \nwww.facebook.com/easyread \nWhatsapp: +2348065768919 \n00. Main Menu";

    else 
        $response = $error_menu;

} else if($count == 2) {

    $response = "CON Select subjects by using comma eg 1,2 for Maths & English";
    $response .= "\n1.Maths";
    $response .= "\n2.English";
    $response .= "\n3.Business studies";
    $response .= "\n4.Basic Science";
    $response .= "\n5.Civic Edu";
    $response .= "\n6.History";

} else if($count == 3) {

    $subjOpt = array_map('trim', explode(',', $steps[2]));
    $subjArr = array();

    foreach ($subjOpt as $subj) {
        $subjRes = getSelectedSubject($subj);
        $subjArr[] = $subjRes;

        if($subjRes != "N/A" and $subjRes != "none") {
            saveSubsription(
                $subjRes,
                $phoneNumber
            );
            pushSMSAfterUSSD(
                $subjRes,
                $phoneNumber
            );
        }
               
    }

    if(in_array("N/A", $subjArr))
        $response = $error_menu;
    else {

        $response = "CON Thanks for registering your subjects. You would receive the SMS contact for each subject to enable you ask questions. \n00. Main Menu";
        writeToLogger(
            $phoneNumber ." <br />[DETAILS PROVIDED] ". $steps[1] ." <br />[SUBJECT PICKED] ". join(", ", $subjArr)
        );
        
    }        

} else 
    $response = $error_menu;

header('Content-type: text/plain');
echo $response;

function getSelectedSubject($s) {

    if($s == 1)
        return Subjects::maths;
    else if($s == 2)
        return Subjects::english;
    else if($s == 3)
        return Subjects::business_studies;
    else if($s == 4)
        return Subjects::basic_science;
    else if($s == 5)
        return Subjects::civic_education;
    else if($s == 6)
        return Subjects::history;
    else if($s == " ")
        return "none";
    else 
        return "N/A";
}

function getInput($t) {
    $inputArr    = explode("*", $t);
    $revInputArr = array_reverse($inputArr);
    $newInputArr = array();

    foreach($revInputArr as $arr) {
        if($arr == "00")
            break;
        else 
            $newInputArr[] = $arr;
    }

    $finalInputArr = array_reverse($newInputArr);
    $finalInput    = join("*", $finalInputArr);
    return $finalInput;
}