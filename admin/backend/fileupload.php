<?php
include("backend/functions.php")
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["publish"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        
               $link = mconnect_to_database();
                    if( mysqli_connect_error()){
                         die("hello");
                     }
       
      $category=$_POST['category']; 
      $subcategory=$_POST['subcategory'];
      $price=$_POST['price'];
      $name=$_POST['name'];
      $description=$_POST['description']; 
      $quantity=$_POST['quantity']; 
      $image="admin/backend/upload/". basename( $_FILES["fileToUpload"]["name"]);
      
      $query="INSERT INTO `productsinfo` (name, price, description,image,category,subcategory,quantity)
VALUES ('$name', '$price', '$description','$image','$category','$subcategory','$quantity')";
$result = mysqli_query($link,$query);
if($result){
    echo "done adding product";
}

        
        
        
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
