<?php

require __DIR__ . "/../libs/loader.php";

use Libs\DB;

$sql = "SELECT * FROM users";
$perPage = 3;
$onEachSide = 1;

echo "-------------------------------------------------------" . PHP_EOL;
$page = 1;
$users = (new DB)->raw($sql)->paginate($perPage)->onEachSide($onEachSide);
$lastPage = $users->lastPage;
echo "Page {$page}/{$lastPage}:" . PHP_EOL;
foreach ($users as $user) {
    echo sprintf("%3d: %s <%s>", $user["id"], $user["name"], $user["email"]) . PHP_EOL;
}

echo "-------------------------------------------------------" . PHP_EOL;
$page = 10;
$users = (new DB)->raw($sql)->paginate($perPage, $page)->onEachSide($onEachSide);
$lastPage = $users->lastPage;
echo "Page {$page}/{$lastPage}:" . PHP_EOL;
foreach ($users as $user) {
    echo sprintf("%3d: %s <%s>", $user["id"], $user["name"], $user["email"]) . PHP_EOL;
}

echo "-------------------------------------------------------" . PHP_EOL;
$users->links();
