<?php


$cfg=[
    "host"=>"127.0.0.1",
    "user"=>"root",
    "pass"=>"",
    "charset"=>"utf8",
    "port"=>3306
];
$DBH = new PDO("mysql:host={$cfg["host"]};port={$cfg["port"]};",
        $cfg["user"],
        $cfg["pass"]
        /*[
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES=> 0
        ]*/
);

try{
    $DBH->exec("USE `Hotels`");
    echo "Установка не требуется";
    echo '<a href="/">Перейти к спискам</a>';
}catch (Exception $e){

    $sql = file_get_contents("install.sql");

    $DBH->exec($sql);

    ?>
    Установка завершена
    <a href="/">Перейти к спискам</a>
<?php
}

