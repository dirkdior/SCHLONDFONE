<?php

require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

function pushNotes($subj) {

    $recipients = loadSubsribers($subj);

    $state      = getStateConf($subj);

    $message    = loadSMSContentCron(
        $subj,
        $state
    );

    sendSMS(
        substr($recipients, 0, -2),
        $message
    );
}

function pushSMSAfterUSSD($sub, $phn) {

    $m = loadSMSContentInitial($sub);

    sendSMS(
        $phn,
        $m
    );
}

function loadSubsribers($subj) {
    $pathToFile = "alegeh/data/".$subj.".txt";

    if($subj == Subjects::maths)
        return file_get_contents($pathToFile);
    else if($subj == Subjects::english)
        return file_get_contents($pathToFile);
    else if($subj == Subjects::business_studies)
        return file_get_contents($pathToFile);
    else if($subj == Subjects::basic_science)
        return file_get_contents($pathToFile);
    else if($subj == Subjects::civic_education)
        return file_get_contents($pathToFile);
    else if($subj == Subjects::history)
        return file_get_contents($pathToFile);
    
}

function loadSMSContentCron($subj, $state) {
    if($subj == Subjects::maths)
        return mathNotes($state);
    else if($subj == Subjects::english)
        return englishNotes($state);
    else if($subj == Subjects::business_studies)
        return busStudiesNotes($state);
    else if($subj == Subjects::basic_science)
        return basicSciNotes($state);
    else if($subj == Subjects::civic_education)
        return civicNotes($state);
    else if($subj == Subjects::history)
        return historyNotes($state);
}

function getStateConf($subj) {
    $pathToFile = "alegeh/config/".$subj.".conf";

    if($subj == Subjects::maths){
        $state = file_get_contents($pathToFile);
        
        if($state > 3)
            $state = 1;
        
        $newState = $state + 1;
        file_put_contents(
            $pathToFile, 
            $newState
        );
        
        return $state;

    } else if($subj == Subjects::english) {
        $state = file_get_contents($pathToFile);

        if($state > 2)
            $state = 1;
        
        $newState = $state + 1;
        file_put_contents(
            $pathToFile, 
            $newState
        );
        
        return $state;

    } else if($subj == Subjects::business_studies) {
        $state = file_get_contents($pathToFile);
        
        if($state > 3)
            $state = 1;
        
        $newState = $state + 1;
        file_put_contents(
            $pathToFile, 
            $newState
        );
        
        return $state;

    } else if($subj == Subjects::basic_science) {
        $state = file_get_contents($pathToFile);
        
        if($state > 3)
            $state = 1;
        
        $newState = $state + 1;
        file_put_contents(
            $pathToFile, 
            $newState
        );
        
        return $state;

    } else if($subj == Subjects::civic_education) {
        $state = file_get_contents($pathToFile);
        
        if($state > 5)
            $state = 1;
        
        $newState = $state + 1;
        file_put_contents(
            $pathToFile, 
            $newState
        );
        
        return $state;

    } else if($subj == Subjects::history) {
        $state = file_get_contents($pathToFile);
        
        if($state > 10)
            $state = 1;
        
        $newState = $state + 1;
        file_put_contents(
            $pathToFile, 
            $newState
        );
        
        return $state;

    }
}

function loadSMSContentInitial($subj) {
    if($subj == Subjects::maths)
        return "MATHEMATICS NOTES\nAddition:\nDefinition: this requires you to count two or more numbers to get one whole number. E.g.\n 1. 1+1 = 2\n 2. 2+3+5 = 10\nFor example1, the two added numbers are 1 and the whole number =2\nExample2, the added numbers are 2,3 and 5. The whole number =10";
    else if($subj == Subjects::english)
        return "ENGLISH NOTES\nSummary writing\n1. A summary is an abridged version of a text. It is informative.\n2. A passage is made up of key sentences. Each paragraph has a key sentence called the topic sentence.\n3. Identification of the topic sentence is important in every summary exercise.\n4. The topic in a paragraph summarises the main idea of that paragraph.\n5. The topic sentence is often, but not always the first sentence in a paragraph. It could be in the middle or end of the paragraph.";
    else if($subj == Subjects::business_studies)
        return "BUSINESS STUDIES NOTES\nCOMPREHENSIVE & 3RD PARTY COVER IN VEHICLE INSURANCE\nComprehensive insurance provides total or full coverage for the insured & 3rd parties in case of fire, damage, theft, injuries or even death, whilst 3rd party insurance covers another person whose vehicle has been damaged by the insured.";
    else if($subj == Subjects::basic_science)
        return "BASIC SCIENCE NOTES\nTopic: HABITAT\nHabitat is an ecological or environmental area that is inhabited by organisms.\nTypes of habitat:\n 1. Forest\n 2. Desert\n 3. Water\n 4. Grassland\n 5. Neighbourhood";
    else if($subj == Subjects::civic_education)
        return "CIVIC EDUCATION NOTES\nTopic: State & Capitals:\n Abia = Umuahia\n Adamawa = Yola\n Akwa-Ibom = Uyo\n Anambra = Awka\n Bauchi = Bauchi \nBayelsa = Yenagoa \nBornu = Maiduguri";
    else if($subj == Subjects::history)
        return "HISTORY NOTES\nThe Amalgamation of Northern and Southern Nigerian Protectorate by Lord Lugard in 1914, led to the emergence of the geographical territory called Nigeria.";
}

function logMsg($nature, $msg){
    date_default_timezone_set('Africa/Lagos');
    $date = date('Y-m-d H:i:s');

    file_put_contents("alegeh/app.log", $date." [".$nature."] ".$msg."\n", FILE_APPEND);
}

function saveSubsription($s, $p) {
    file_put_contents("alegeh/data/".$s.".txt", $p.", ", FILE_APPEND);
}

function writeToLogger($msg) {
    date_default_timezone_set('Africa/Lagos');
    $date = date('Y-m-d H:i:s');

    file_put_contents("alegeh/ussdEntry.log", $date." [SIGNUP] ".$msg."\n <br /> <br />", FILE_APPEND);
}

function sendSMS($r, $m) {

    $username   = "";
    $apiKey     = "";

    $AT         = new AfricasTalking($username, $apiKey);

    $sms        = $AT->sms();

    $from       = "SCHLONDFONE";

    $recipients = $r;

    $message    = $m;

    try {
        $result = $sms->send([
            'to'      => $recipients,
            'message' => $message,
            'from'    => $from
        ]);
        
        logMsg(
            "INFO",
            json_encode($result)
        );
        
    } catch (Exception $e) {
        logMsg(
            "ERROR",
            "".$e->getMessage()
        );
    }
}

function mathNotes($s) {
    $noteHeader = "MATHEMATICS\n";

    if($s == 1)
        return $noteHeader."Division:\nDefinition: it means to split two numbers. The smaller number (denominator) is often used to split the bigger number (numerator).\nE.g. 1. 10÷5 =2\nExplanation:\nThe intention is to calculate how many times the denominator can go into the nominator. In this case, the answer is 2.";
    else if($s == 2)
        return $noteHeader."Subtraction:\nDefinition: This often requires that you deduct a smaller number from a larger number to get the final result.\ne.g. 5-3 = 2\nExplanation:\nThe smaller number, in this case, is 2 and  when deducted from 5(larger number) the final result is 3.";
    else if($s == 3)
        return $noteHeader."Addition:\nDefinition: this requires you to count two or more numbers to get one whole number. E.g.\n 1. 1+1 = 2\n 2. 2+3+5 = 10\nFor example1, the two added numbers are 1 and the whole number =2\nExample2, the added numbers are 2,3 and 5. The whole number =10";
}

function englishNotes($s) {
    $noteHeader = "ENGLISH\n";

    if($s == 1)
        return $noteHeader."Noun:\nDefinition: it’s the name of a person, place or thing. It can perform various functions in a sentence.\nSome functions of a noun\n 1. Subject of a verb. E.g. RAJI is hardworking.\n 2. Direct object, e.g. Kayode gave THE RULER to Fatima.\n 3. Indirect object, i.e. Kayode gave FATIMA, the ruler.\n 4. Subject compliment, Funmi is A STUDENT.";
    else if($s == 2)
        return $noteHeader."Summary writing\n1. A summary is an abridged version of a text. It is informative.\n2. A passage is made up of key sentences. Each paragraph has a key sentence called the topic sentence.\n3. Identification of the topic sentence is important in every summary exercise.\n4. The topic in a paragraph summarises the main idea of that paragraph.\n5. The topic sentence is often, but not always the first sentence in a paragraph. It could be in the middle or end of the paragraph.";
}

function busStudiesNotes($s) {
    $noteHeader = "BUSINESS STUDIES\n";

    if($s == 1)
        return $noteHeader."CONSUMER EDUCATION.\nDEFINITION: It is the process of making consumers aware of their rights during the purchase of goods & services.";
    else if($s == 2)
        return $noteHeader."CONSEQUENCES OF LACK OF CONSUMER EDUCATION.\n 1. It leads to exploitation\n 2.  Enhances the sale & distribution of fake products.\n 3.  Prevents consumers from seeking redress for bad customer services.\n 4. Allows businesses avoid sanctions for their bad services to consumers";
    else if($s == 3)
        return $noteHeader."COMPREHENSIVE & 3RD PARTY COVER IN VEHICLE INSURANCE\nComprehensive insurance provides total or full coverage for the insured & 3rd parties in case of fire, damage, theft, injuries or even death, whilst 3rd party insurance covers another person whose vehicle has been damaged by the insured.";
}

function basicSciNotes($s) {
    $noteHeader = "BASIC SCIENCE\n";

    if($s == 1)
        return $noteHeader."ADAPTATION\nIt is the ability of organisms to live in certain habitats. They are only able to adapt to specific environments, due to:\n1. Genetic makeup\n2. Body structure";
    else if($s == 2)
        return $noteHeader."HOW ORGANISMS RELATE:\n 1. Symbiotic\n 2. Mutualism\n 3. Parasitic\n 4. Predation\n 5. Competition\nThis is better explained by the food chain, which shows how organisms relate with each other by the food they eat.";
    else if($s == 3)
        return $noteHeader."Topic: HABITAT\nHabitat is an ecological or environmental area that is inhabited by organisms.\nTypes of habitat:\n 1. Forest\n 2. Desert\n 3. Water\n 4. Grassland\n 5. Neighbourhood";
}

function civicNotes($s) {
    $noteHeader = "CIVIC EDUCATION\n";

    if($s == 1)
        return $noteHeader."Topic: State & Capitals:\n Cross-Rivers = Calabar\n Delta = Asaba\n Ebonyi = Abakaliki\n Edo = Benin-City\n Enugu = Enugu\n Ekiti = Ado-ekiti\n FCT = Abuja\n Gombe = Gombe";
    else if($s == 2)
        return $noteHeader."Topic: State & Capitals:\n Imo = Owerri\n Jigawa = Dutse\n Kaduna = Kaduna\n Kano = Kano\n Kastina = Kastina\n Kebbi = Birnin-Kebbi\n Kogi = Lokoja\n Kwara = Ilorin";
    else if($s == 3)
        return $noteHeader."Topic: State & Capitals:\n Lagos = Ikeja\n Nasarawa = Lafia\n Niger = Minna\n Oyo = Ibadan\n Osun = Oshogbo\n Ogun = Abeokuta\n Ondo = Akure\n Plateau = Jos";
    else if($s == 4)
        return $noteHeader."Topic: State & Capitals:\n Rivers = Port-Harcourt\n Sokoto = Sokoto\n Taraba = Jalingo\n Yobe = Damaturu\n Zamfara = Gusau";
    else if($s == 5)
        return $noteHeader."Topic: State & Capitals:\n Abia = Umuahia\n Adamawa = Yola\n Akwa-Ibom = Uyo\n Anambra = Awka\n Bauchi = Bauchi \nBayelsa = Yenagoa \nBornu = Maiduguri";
}

function historyNotes($s) {
    $noteHeader = "HISTORY\n";

    if($s == 1)
        return $noteHeader."ASO ROCK VILLA, the official residence of the President of Nigeria, since 1991, is named after the collection of undulating hills surrounding the vicinity.";
    else if($s == 2)
        return $noteHeader."AGUDA HOUSE, official residence of Nigeria’s Vice President is named after Justice AKINOLA AGUDA. His committee (1976) proposed Abuja, as new Federal Capital";
    else if($s == 3)
        return $noteHeader."The legal tender in Nigeria changed from the pound sterling to the Naira on 1st January, 1973.";
    else if($s == 4)
        return $noteHeader."RIBADU HOUSE, (State House Marina), official seat of Nigeria’s government until 1991 is named after her First Minister of Defense, Alhaji Inuwa Ribadu.";
    else if($s == 5)
        return $noteHeader."Nigeria operates a Bi-Cameral National Assembly, at the federal Level, with (360) members of the House of Representatives & (109) members of the Senate.";
    else if($s == 6)
        return $noteHeader."Prof. Grace Alele-Willams was the FIRST FEMALE VICE-CHANCELLOR (V.C) of a Nigerian university. She was V.C of University of Benin from 1985-1991.";
    else if($s == 7)
        return $noteHeader."Major General R. Aderonke Kale, was the First Female General in the Nigerian Army, she was elevated to the position of Major General on 31st Dec. 1994.";
    else if($s == 8)
        return $noteHeader."Nigeria’s first & only Prime Minister was Sir Ahmadu Bello. He came into office through his party, the Northern People’s Congress & served from 1960-1966.";
    else if($s == 9)
        return $noteHeader."Chief Anthony Enahoro, 1922-2011, in 1957, moved the motion for Nigeria’s independence from Britain. Nigeria got her independence, on 1st October 1960.";
    else if($s == 10)
        return $noteHeader."The Amalgamation of Northern and Southern Nigerian Protectorate by Lord Lugard in 1914, led to the emergence of the geographical territory called Nigeria.";
}