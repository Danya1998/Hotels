<?php
include "db.php";
try{
    $db = Database::instance();
    $countries = $db->countries->getAll();
    include_once "lists.php";
}catch (Exception $e){
    ?>
База данных не найдена, установить?
    <a href="install.php">начать установку</a>
<?php
}



