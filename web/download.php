<?php

$name = $_POST["nombre"];
$filename = exec("python3 client.py upload $filename");
// $filename = "./uploads/" . $name;

if ($filename === "File not found") {
    header("Location: ./index.php?action=download&err=1");
} else {
    if (file_exists($filename)) {
        header('Content-Description: File download');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        unlink($filename);
        exit;
    } else {
        header("Location: ./index.php?action=download&err=2");
    }
}
