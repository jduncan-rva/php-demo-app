<html>
<head>
<title>Image Library Demo Application by Jamie Duncan</title>
<style>
body {
    background-color: lightgrey;
    font-family: arial;
}

#body-wrapper {
    background-color: white;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 40px;
    border-radius: 25px;
    padding: 25px;
    padding-bottom: 200px;
}

h1 {
    font-family: arial;
}
img {
    padding: 10px;
}
.wrapper {
    border-radius: 25px;
    border: 1px solid #333;
    padding: 25px;
    width: 40%;
    margin: 20px;
}
#upload-form {
    background-color: #ddd;
}

#results-box {
    width: 40%;
    color: red;
    font-color: #fff;
    font-weight: bold;
}

</style>
</head>
<body>
<div id="body-wrapper">
<h1>My Image Library</h1>
<div class="wrapper" id="upload-form">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <p><input type="file" name="fileToUpload" id="fileToUpload"></p>
    <p><input type="submit" value="Upload Image" name="submit"></p>
</form>
</div>
<?php
$target_dir = "uploads/";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
echo "<div class='wrapper' id='results-box'>";
if(isset($_POST["submit"])) {
    echo "<h3>Image Scan Results:</h3>";
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "<p>File is an image - " . $check["mime"] . ".</p>";
        $uploadOk = 1;
    } else {
        echo "<p>File is not an image.</p>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "<p>Sorry, file already exists.</p>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<p>Sorry, your file is too large.</p>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
    $uploadOk = 0;
}
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<p>". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
    }
}
echo "</div>";
}
echo "<h3>Uploaded Files</h3>";
$files = array_diff(scandir($target_dir), array('.', '..','uploads'));
foreach ($files as $f) {
  echo "<a href='uploads/$f'><img src='uploads/$f'/></a>";
}
?>
</div>
</body>
</html>
