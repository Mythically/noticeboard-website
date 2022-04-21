<?php
function getNat($name)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.nationalize.io?name=" . $name,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    $response = json_decode($response, true); // true, therefore it's in an array

    return $response['country'];
}




//foreach($countries as $country) {
//    echo $country['country_id'] . ' ' . $country['probability'] . "<br>";
//}

//print_r($response['name']);
//print_r($response['country']);
//$test = "";
//foreach ($response as $array) {
//    foreach($array as $key=>$value) {
//    $name        = $array ;
//    $country     = $key;
//    $nationality = $value;
//    $test .= $name . " " . $country . " " . $nationality;
//}
//}
//print_r(sizeof($response));
//echo $test;
//echo "<br><br>";
//var_dump($response);
//$strings = explode(" ", $response);
//
//echo $strings;
//
//foreach($response as $result) {
//    var_dump($result['name']);
//}

//print_r( $response);
//stdClass Object (
//    [name] => michael [country] => Array ( [0] => stdClass Object (
//        [country_id] => US [probability] => 0.089864822665327 ) [1] => stdClass Object (
//            [country_id] => AU [probability] => 0.059767575270831 ) [2] => stdClass Object (
//                [country_id] => NZ [probability] => 0.046669748208529 ) ) )
//string(7) "michael" array(3) { [0]=> object(stdClass)#3 (2) { ["country_id"]=> string(2) "US" ["probability"]=> float(0.08986482266532715) } [1]=> object(stdClass)#4 (2) { ["country_id"]=> string(2) "AU" ["probability"]=> float(0.05976757527083082) } [2]=> object(stdClass)#5 (2) { ["country_id"]=> string(2) "NZ" ["probability"]=> float(0.04666974820852911) } }