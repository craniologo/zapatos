<?php
if(count($_POST)>0){
  $product = new MaterialData();
  $product->name = $_POST["name"];
  $product->add();
  print "<script>window.location='index.php?view=details';</script>";
}
?>