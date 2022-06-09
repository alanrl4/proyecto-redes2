<?php

$dir = "./uploads/";
$filename = $dir . basename($_FILES["archivo"]["name"]);

if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $filename)) {
    $ret = exec("python3 client.py upload $filename");
    unlink($filename);
    $ret = "done";
    if ($ret === "done") {
        header("Location: ./index.php?action=upload&err=0");
    } else {
        header("Location: ./index.php?action=upload&err=2");
    }
} else {
    header("Location: ./index.php?action=upload&err=1");
}
