<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
    require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");

    $buffer = str_replace("data:image/png;base64,", "", $_POST['drawing']);
    $buffer = str_replace(" ", "+", $buffer);
    
    $image = base64_decode($buffer);
    $filename = md5(time()) . uniqid() . ".png";

    $fileUploaded = file_put_contents("../dynamic/art/" . $filename, $image);

    if(!$fileUploaded) {
        die("error");
    } else {
        echo "success";

        $stmt = $conn->prepare("INSERT INTO files (type, title, extrainfo, author, filename, thumbnail) VALUES ('art', 'Drawing', '', ?, ?, '')");
        $stmt->bind_param("ss", $_SESSION['user'], $filename);
        $stmt->execute();
        $stmt->close();
    }
?>