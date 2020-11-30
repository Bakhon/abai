<?php

$file = 'https://yandex.ru/news/quotes/graph_1006.json';
$file_name = 'D:/openserver/OpenServer/domains/localhost/public/js/json/graph_1006.json';
file_put_contents($file_name, file_get_contents($file));



/*
$URL = 'https://yandex.ru/news/quotes/graph_1006.json';
$PATH="D:/openserver/OpenServer/domains/localhost/public/graph_1006.json";
downloadFile($URL,$PATH);


function downloadFile ($URL, $PATH) {
    $ReadFile = fopen ($URL, "rb");
    if ($ReadFile) {
        $WriteFile = fopen ($PATH, "wb");
        if ($WriteFile){
            while(!feof($ReadFile)) {
                fwrite($WriteFile, fread($ReadFile, 4096 ));
            }
            fclose($WriteFile);
        }
        fclose($ReadFile);
    }
}*/
?>