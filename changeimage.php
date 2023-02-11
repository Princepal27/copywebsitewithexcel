<?php
unlink("D:/xampp/htdocs/demo11/wp-content/uploads/2023/02/demo11.png");
$imgsrc = "D:/xampp/htdocs/demo11/demo1.png";
$imgdes = "D:/xampp/htdocs/demo11/wp-content/uploads/2023/02/demo.png";
copy($imgsrc,$imgdes);
echo "successfully image change";
unlink($imgsrc);
echo "successfully image change";
?>