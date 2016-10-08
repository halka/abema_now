<?php
//get timetable
header("Content-Type: application/json; charset=utf-8");
error_reporting(0);
date_default_timezone_set('Asia/Tokyo');
$url = 'https://api.abema.io/v1/media?dateFrom='.date('Ymd').'&'.'dateTo='.date('Ymd');
$token = '<get the beaer token from developer tools of browser>';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: bearer '.$token));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$result = curl_exec($curl);
curl_close($curl);
$timetable = json_decode($result, true);

//get channel name
$channelNames = [];
for($i = 0; $i < count($timetable["channelSchedules"]); $i++){
array_push($channelNames, $timetable["channels"][$i]["name"]);
}

//var_dump($channelNames);
$nowOnAir = [];
$videolist = $timetable["channelSchedules"];
for($i = 0; $i < count($videolist); $i++){
// echo $channelNames[$i].' ';
for($j = 0; $j < count($videolist[$i]["slots"]); $j++){
$option = array('options'=>array('min_range' => $videolist[$i]["slots"][$j]["startAt"], 'max_range' =>  $videolist[$i]["slots"][$j]["endAt"]));
if(filter_var(time(), FILTER_VALIDATE_INT, $option)){
    $title = $videolist[$i]["slots"][$j]["title"];
    if(count($title)>0){
            }
            else{
                $title = "放送されていません";
            }
            // echo date('H:i', $videolist[$i]["slots"][$j]["startAt"]).'-'.date('H:i', $videolist[$i]["slots"][$j]["endAt"])."\n";
            // echo "\t".$title."\n";
            $now = ["channel" => $channelNames[$i], "title" => $title, "content"=>$videolist[$i]["slots"][$j]["content"], "startAt" => date('H:i', $videolist[$i]["slots"][$j]["startAt"]), "endAt" => date('H:i', $videolist[$i]["slots"][$j]["endAt"])];
            array_push($nowOnAir, $now);
        }
    }
}
echo json_encode($nowOnAir);
