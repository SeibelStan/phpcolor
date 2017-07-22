<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('lib.php');

$dir = 'test/';
$files = scandir($dir);
$result = [];
foreach($files as $file) {
    if($file[0] != '.') {
        $value = rgbToHsv(getRgb($dir . $file))[2];
        array_push($result, [
            'value' => $value,
            'file' => $dir . $file
        ]);
    }
}

?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        display: flex;
        flex-wrap: wrap;
    }
    .wraper {
        position: relative;
        width: 20%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .wraper h1 {
        display: inline-block;
        position: absolute;
    }
    img {
        max-width: 100%;
    }
</style>

<?php foreach($result as $row) : ?>
    <div class="wraper" style="color: <?= $row['value'] < 50 ? 'white' : 'black' ?>">
        <img src="<?= $row['file'] ?>">
        <h1><?= $row['value'] ?></h1>
    </div>
<?php endforeach; ?>