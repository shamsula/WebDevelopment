<html>
<head>
<script type="text/javascript"src="https://www.gstatic.com/charts/loader.js"></script>



</head>
<body>
<?php //sectionb.php

require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
 $query= <<<_END

SELECT category,count(*) as cnt
FROM classics
group by category;

_END;

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);

$rows = $result->num_rows;
$category = new SplFixedArray($rows);
$count = new SplFixedArray($rows);
for ($j = 0; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    $category[$j] = $row[0] ;

    $cnt[$j] = $row[1] ;

}  

?>
<script type="text/javascript">var category =<?php echo json_encode($category); ?>;</script> 
<script type="text/javascript">var cnt =<?php echo json_encode($cnt); ?>;</script>
<script type="text/javascript" src="../js/sectionb.js"></script>
<div id="piechart"> </div>
</body>
</html>
