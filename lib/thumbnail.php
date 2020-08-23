<?php
return function($allowedFileTypes, $conn) {
    if(isset($_SESSION['user'])) {
        $fileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/dynamic/thumbnails/";
        $target_name = md5_file($_FILES["thumbnail"]["tmp_name"]) . "." . $fileType;
        $target_file = $target_dir . $target_name;
        $uploadOk = true;
        $movedFile = 0;
        
    
        if (file_exists($target_file)) {
            $movedFile = true;
        } else {
            $movedFile = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file);
        }

        if(!in_array($fileType, $allowedFileTypes)) {
            echo 'unsupported file type. must be one of ' . join(", ", $allowedFileTypes) . '<hr>';
            $uploadOk = false;
        }

        if ($uploadOk) {
            if ($movedFile) {
				$stmt = $conn->prepare("UPDATE files SET thumbnail = ? WHERE id = ?");
				$stmt->bind_param("si", $target_name, $_SESSION['id']);
				$stmt->execute();
				$stmt->close();
				
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