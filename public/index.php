<!doctype html>
<html>
    <head>
        <title>Pure PHP Paginator with PDOStatement Wrapper</title>
        <meta charset="utf-8">
    </head>
    <body>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <div class="card">
            <div class="card-body">
<?php

require __DIR__ . "/../libs/loader.php";

use Libs\DB;

$sql = "SELECT * FROM users";
$perPage = 3;
$onEachSide = 1;
$currentPage = $_GET["page"] ?? 1;

$users = (new DB)->raw($sql)->paginate($perPage)->onEachSide($onEachSide);
$lastPage = $users->lastPage;
?>
    <p>
<?php
echo "Page {$currentPage}/{$lastPage}:" . PHP_EOL;
?>
    </p>
    <ul class="list-group">
    <?php
    foreach ($users as $user) {
    ?>
        <li class="list-group-item">
            <?php echo sprintf("%3d: %s &lt;%s&gt;", $user["id"], $user["name"], $user["email"]) ?>
        </li>
    <?php
    }
    ?>
    </ul>
    <?php
    $users->links();
    ?>
            </div>
        </div>
    </body>
</html>
