<?php

include('fc.php');
$obj = new copy;
$time_start = microtime(true); 

$user = 'root';
$pass = '';
$host = 'localhost';
$sql_file_OR_content = 'backup.sql';

require 'vendor/autoload.php';
$inputFileName = 'Book1.xlsx';
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

$spreadsheet = $reader->load($inputFileName);

$worksheet = $spreadsheet->getActiveSheet();

$highestRow = $worksheet->getHighestRow(); // e.g. 10
$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

$rows = [];
for ($row = 1; $row <= $highestRow; ++$row) 
{
    $col = 1;
    $cell = $worksheet->getCellByColumnAndRow($col, $row);
    // Skip empty cells
    while (in_array($cell->getValue(), [null, ''], true))
    {
        $col++;
        $cell = $worksheet->getCellByColumnAndRow($col, $row);
    }
    $maxCol = $col + 1;
    for ( ; $col <= $maxCol; ++$col) 
    { 
        $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
        $rows[$row][$col] = $value;
    }
}
foreach($rows as $row)
{
    $src = $row[1];
    $dst = $row[2];
    $delimiter = "/";
    $words = explode($delimiter, $src);
    $db = end($words);
    $word = explode($delimiter, $dst);
    $ndb = end($word);
    $obj->custom_copy($src, $dst,$db,$ndb);
    $obj->Export_Database($host,$user,$pass,$db,$ndb,  $tables=false, $backup_name=false );
    $obj->IMPORT_TABLES($host, $user, $pass, $ndb, $sql_file_OR_content);
    echo "successfully copy at " . $dst;
    echo "<br>";
    unlink('backup.sql');
   
}
// unlink("D:/xampp/htdocs/demo11/wp-content/uploads/2023/02/demo11.png");
// $imgsrc = "D:/xampp/htdocs/demo11/demo1.png";
// $imgdes = "D:/xampp/htdocs/demo11/wp-content/uploads/2023/02/demo.png";
// copy($imgsrc,$imgdes);
// // echo "successfully image change";
// unlink($imgsrc);
// echo "successfully image change";

$time_end = microtime(true);
$time = ($time_end - $time_start);
$time = number_format((float)$time, 3, '.', '');
echo "Process Time: {$time} sec";

?>