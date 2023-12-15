<?php

//connection
$db = new PDO
(
    'mysql:host=127.0.0.1;dbname=lighthouse',
    'dckap',
    'Dckap2023Ecommerce'
);


date_default_timezone_set("Asia/Kolkata");
$currentDateTimeIndia = date("Y-m-d_H:i:s_A");

$projectName = $_POST['project_name'];
$projectNameWithTime = $projectName."_".$currentDateTimeIndia;

$hidden_p_n = $_POST["p_n"];
$hidden_p_n = $projectName;

$siteURL = $_POST['url'];
$generate = $_POST['generate'];


if (isset($generate)) {

    $uploads_dir = "reports/$projectNameWithTime.html";

//    $command = 'lighthouse ' . escapeshellarg($siteURL) . ' --output=html --output-path=' . $uploads_dir;
    $command = 'lighthouse '.  escapeshellarg($siteURL) . ' --quiet --chrome-flags="--headless" --output=html --output-path=' . $uploads_dir;
    $output = shell_exec($command);

    try
    {
        $statement = $db->query("INSERT INTO qa_lighthouse(projectNameWithTime, hidden_p_n, siteURL, filePath, created_at, updated_at) VALUES('$projectNameWithTime', '$hidden_p_n', '$siteURL', '$uploads_dir', now(), now())");
        header( "location:/");
        echo "<script>alert('Generated successfully')</script>";
    }
    catch (PDOException $e)
    {
        die($e->getMessage());
    }

}

require "index.php";
