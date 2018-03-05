<?php
 header('Access-Control-Allow-Origin: *');  
	
	
   if(isset($_FILES['image'])){
	   $name = $_POST['fileName'];
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
     // $name.=".".$file_ext;
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      print_r($name);
      if($file_size > 209715002){
         $errors[]='File size must be excately 20 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"Files/".$name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
   else{
   echo "image not found";
   }
?>