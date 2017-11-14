<? include_once("pf_core.php"); ?>
<?
    PF_DB_connect("localhost", "<your-database-name>", "<your-database-password>");
    PF_DB_select("<your-database-name>");
    PF_DB_table("catalogue");
?>
<?
/*if ( $_GET['LANG'] == "EN" ) {
    PF_setLANG("EN");
}
if ( $_GET['LANG'] == "DE" ) {
    PF_setLANG("DE");
}*/
?>
<body>
    <h2>Catalogue</h2>
    
    <? PF_DB_table("description"); ?>

    <? PF_setLANG("EN"); ?>
    <? echo "Current Language: " . ${g_USER_LANG}; ?>
    <? PF_query("SELECT * FROM description WHERE lang='${g_USER_LANG}'", NULL); ?>

    <!-- show the description out of database -->
    <div style="background-color:#eeeeee">#desc#</div>



<? PF_DB_table("catalogue"); ?>



<?

$g_SQL_fields = ""
. PF_HTML_checkbox_to_SQL("greenlabel")
. PF_HTML_radio_option_to_SQL("ps")
. PF_HTML_radio_option_to_SQL("size")
. PF_HTML_radio_option_to_SQL("consumption")
;

$g_sql = "SELECT * FROM "
. " $g_DB_table "
. " WHERE (1) "
. $g_SQL_fields
;

//PF_debug(true);
//PF_debug(false);

$result = mysqli_query($g_con, $g_sql);


PF_CSV_to_HTML_table($g_sql, "Detail", "cat_detail.php?id=");



?>




<hr>

<h2>PF_use_template()</h2>

<p>
With PF_use_template you can process a PhpFusion file.
</p>

<?
PF_DB_table("catalogue");
pf_loop_query($g_sql, "catalogue", "size", "carbrand", "carname");
PF_use_template("mytemplate.php", 1);
?>

<hr>


 

<h2>Create CSV tables</h2>

<?
echo "<pre>";
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	//echo '<a href=' . "cat_detail.php?id=" . $row['id'] . ">Detail</a>";
	echo
		'"' . $row['id'] . '"'          . ', ' .
		'"' . $row['carbrand'] . '"'    . ', ' .
		'"' . $row['carname'] . '"'     . ', ' .
		'"' . $row['size'] . '"'        . ', ' .
		'"' . $row['consumption'] . '"' . ', ' .
		'"' . $row['ps'] . '"'          . ', ' .
		'"' . $row['greenlabel'] . '"';
	echo "<br/>";
}
echo "</pre>";

?>

</body>
</html>
<? PF_DB_close(); ?>
<? ob_end_flush();
