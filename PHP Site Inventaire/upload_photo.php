<?php
$error_messages = [];

// check if the form was submitted
if (!empty($_GET['submit'])) {
  
  $valid = true;

  // check if there are values in $_POST
  if (!isset($_POST['submit'])) {
    // the form was submitted but post is empty - the max size was exceeded
    $error_messages[] = 'The file was too large.';
    $valid = false;
  }
  else {

    // see http://php.net/manual/en/features.file-upload.errors.php
    if ($_FILES["fileToUpload"]['error'] != UPLOAD_ERR_OK) {
      switch ($_FILES["fileToUpload"]['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:  $error_messages[] = 'The uploaded file was too large.'; $valid = false; break;
        case UPLOAD_ERR_PARTIAL:    $error_messages[] = 'The uploaded file was only partially received.'; $valid = false; break;
        case UPLOAD_ERR_NO_FILE:    $error_messages[] = 'No file was selected.'; $valid = false; break;
        case UPLOAD_ERR_NO_TMP_DIR: $error_messages[] = 'Missing temporary folder.'; $valid = false; break;
        case UPLOAD_ERR_CANT_WRITE: $error_messages[] = 'Failed to write file to disk.'; $valid = false; break;
        case UPLOAD_ERR_EXTENSION:  $error_messages[] = 'The server stopped the upload.'; $valid = false; break;
      }
    }

    if ($valid) {
      $target_dir = "image/item_photo";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $error_messages[] = "File is an image - " . $check["mime"] . ".";
      } else {
        $error_messages[] = "File is not an image.";
        $valid = false;
      }
      // Check if file already exists
      if (file_exists($target_file)) {
        $error_messages[] = "Sorry, file already exists.";
        $valid = false;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error_messages[] = "Sorry, your file is too large.";
        $valid = false;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        $error_messages[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $valid = false;
      }
      // Check if $valid is set to false by an error
      if ($valid == false) {
        $error_messages[] = "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $error_messages[] = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            $error_messages[] = "Sorry, there was an error uploading your file.";
        }
      }
    }
  }
}


$head = "Location: inventaire_unite.php?unite=" . $_POST['item_unite'];
header($head);
?>