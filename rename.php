<?php
$oldName = $_POST['oldName'];
$newName = $_POST['newName'];
$targetDir = "uploads/";

// Rename file or folder
if (rename($targetDir . $oldName, $targetDir . $newName)) {
    echo "File/Folder renamed successfully.";
} else {
    echo "Error renaming file/folder.";
}
?>
