<?PHP
include("verify.php");
$cols = 3; // put the number of columns you want here
$col_width = round(1/$cols * 100,0)."%"; // get column width as %
$extra_cells = "";
$extra_needed = $cols-($num_rows % $cols); //find out how many blank cells there will be
if($extra_needed!= $cols ){
for($i = 0; $i<$extra_needed;$i++){
$extra_cells .= "<td width=\"$col_width\">&nbsp;</td>\r\n"; // loop the blank cells in
}
}
$result = mysql_query("SELECT * FROM grade_reference");
echo '<table width="80%" border="0" cellspacing="0" cellpadding="0">'."\r\n";
$tdcount = 1; //start cell count at one
while($rows=mysql_fetch_assoc($result)){
if($tdcount % $cols == 1) echo "<tr>\r\n"; // check to see if new row needs to be started

echo "<td width=\"$col_width\"><p><img src='../images/v2/arcade/gunbound/levels/".$rows['Grade_Number'].".gif' alt='' border='' /> ".$rows['Grade_Number']."<br></td>\r\n";
                                                                                                                                   
if($tdcount == $num_rows) echo $extra_cells; //echo extra cells into row
if($tdcount % $cols == 0) echo "</tr>\r\n"; // check to see if row needs to be ended

$tdcount++; // add one to cell count
}
echo "</table> \r\n";


?>