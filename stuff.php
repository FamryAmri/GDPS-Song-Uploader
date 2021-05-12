<?php
include 'config/config.php';

function randnum ($digit = 8){
    $num = '1234567890';
    $rand = substr(str_shuffle($num), 0, $digit);
    return $rand;
}

if (!empty($_FILES['FILE']['name'])){
    $type = $_FILES['FILE']['type'];
    if ($type !== 'audio/mpeg') exit('THIS IS '. strtoupper($type). ' TYPE. PLEASE UPLOAD AUDIO/MPEG TYPE');
    //print_r($_FILES);
    $idupload = randnum();
    $name = $_FILES['FILE']['name'];
    $title = basename($name, '.mp3');
    $file = $_FILES['FILE']['tmp_name'];
    $size = round($_FILES['FILE']['size'] / 1024 / 1024, 2);
    move_uploaded_file($file, 'data/'. $idupload.'.mp3');
    $url = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/data/'.$idupload.'.mp3';
    if ($gdps){
        include '../incl/lib/connection.php';
        $query = $db->prepare('INSERT INTO songs (name, authorID, authorName, size, download, hash) VALUES (:name, "9", "reupload", :size, :url, "")');
        $query->execute([':name' => $title, ':size' => $size, ':url' => $url]);
        $ID = $db->lastInsertId();
        exit('ID inserted: '. $ID);
    } else {
        $ch = curl_init($gdpsurl. '/tools/bot/songAddBot.php?link='. $url.'&name='.urlencode($title).'&author=reupload');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $stat = curl_exec($ch);
        if (is_numeric($stat)) exit('ID inserted: '. $stat);
        echo $stat;
    }
} else {
    header('location: ./');
}
