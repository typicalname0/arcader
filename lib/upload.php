<?php
return function($type, $allowedFileTypes, $conn) {
    if(isset($_SESSION['user'])) {
        $fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/dynamic/" . $type . "/";
        $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $fileType;
        $target_file = $target_dir . $target_name;
        $uploadOk = true;
        $movedFile = 0;
        
    
        if (file_exists($target_file)) {
            $movedFile = true;
        } else {
            $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        }

        if(!in_array($fileType, $allowedFileTypes)) {
            echo 'unsupported file type. must be one of ' . join(", ", $allowedFileTypes) . '<hr>';
            $uploadOk = false;
        }

        if ($uploadOk) {
            if ($movedFile) {
                $stmt = $conn->prepare("INSERT INTO files (type, title, extrainfo, author, filename, thumbnail) VALUES (?, ?, ?, ?, ?, '')");
                $stmt->bind_param("sssss", $type, $title, $description, $_SESSION['user'], $filename);
    
                $filename = htmlspecialchars($target_name);
                $title = htmlspecialchars($_POST['title']);
                $description = htmlspecialchars($_POST['description']);
                $description = str_replace(PHP_EOL, "<br>", $description);
    
                $stmt->execute();
                $stmt->close();
            } else {
                $error = 'fatal error';
            }
        }
    } else {
        $error = "You aren't logged in.";
    }
}
?>