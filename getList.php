<?php
if(empty($_GET["name"])||empty($_GET["id"])) die("params not found");
include "db.php";
$db = Database::instance();
if($_GET["name"]=="city"){
    $data = $db->cities->join("countries","country_id","id")->getColumns(["`cities`.*"],"`countries`.`id`=?",[(int)$_GET["id"]]);
    echo json_encode($data);
}else if($_GET["name"]=="hotels"){
    $data = $db->hotels->join("cities","city_id","id")->getColumns(["`hotels`.*"],"`cities`.`id`=?",[(int)$_GET["id"]]);
    echo json_encode($data);
}