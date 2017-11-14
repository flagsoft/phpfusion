<?php
/*
PhpFusion - Copyright (c) 1996 - 2016 by Michael Mustun <michael.mustun@gmail.com>
 

CFML Reference
https://helpx.adobe.com/coldfusion/cfml-reference/topics.html



*/


/*
<cfquery 
name="getMyFriends" datasource="peter">
SELECT friendId,firstName,lastName,nickName
FROM friends
</cfquery>

<cfloop query="getMyFriends">
#firstName# #lastName#
</cfloop>
*/


include_once("user_config.php");


$g_USER_LANG = "EN";		//


$g_con = NULL;			// DB connection link
$g_DB_table = NULL;
$g_SQL_row = array();		// SQL result

$g_sql = NULL;			// SQL statement

$g_myFields = array();


$g_pf_vars = array();	// assoziative array


function FB_intern_callback($i_buffer) {

    global $g_myFields;
    global $g_SQL_row;

    $output = $i_buffer;
    // replace all PCs with Mac ;)
    //$output = str_replace("PC", "Mac", $i_buffer);
    //$output = str_replace("#answer#", "42", $output);

    foreach ($g_myFields as $element) {

        $searchString = "#${element}#";
        //echo "$searchString";
        
        $val = $g_SQL_row["${element}"];
        //echo "val=" . $val;

        $output = preg_replace("/$searchString/", $val, $output);
        //echo $output;
        
        //$output = preg_replace("/<html>/", "<!-- PHPfusion -->\n<html>", $output);
        
    }

    return ($output);
}

ob_start("FB_intern_callback");




function PF_setLANG($i_lang)
{
    global $g_USER_LANG;
    $g_USER_LANG = "$i_lang";
    return(true);
}


function PF_debug($_flag)
{
    global $g_sql;

    if ($_flag == true) {    
        echo '<div style="background-color:#ffffcc; border:solid 1px #000000; padding:10px">';
        echo "DEBUG: \$_POST";
        echo "<pre>";
        print_r($_POST);
        //print_r($_GET);
        //echo $_POST['greenlabel'][0];
        echo "</pre>";
        echo "</div>";


        echo '<div style="background-color:#ffffcc; border:solid 1px #000000; padding:10px">';
        echo "DEBUG: \$g_sql";
        echo "<pre>";
        print_r($g_sql);
        echo "</pre>";
        echo "</div>";
    }
}


// status: works

function PF_DB_connect($_host, $_user, $_pass)
{
	global $g_con;

	$g_con = mysqli_connect("$_host", "$_user", "$_pass");

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	/*
	$g_con = mysql_connect("$_host", "$_user", "$_pass");
	if (!$g_con) {
		die('Could not connect: ' . mysql_error());
	}
	*/
}

function PF_DB_select($_database)
{
    global $g_con;
    
    mysqli_select_db($g_con,"$_database");
    
    /*
    mysql_select_db("$_database", $g_con);
    */
}

/*
 * 
 * FP_DB_table("catalogue");
 */
function PF_DB_table($_tbl)
{
    global $g_DB_table;
    $g_DB_table = $_tbl;
}


function PF_DB_close()
{
	global $g_con;

	
	//mysqli_close($g_con);
	
	mysqli_close($g_con);
}


/*
 * if ( PF_structKeyExists("form", "action") ) {
 * }
 *
 * <cfif structKeyExists(form, "user")>
 * </cfif>
 * 
 * status: works partially
 */
function CF_structKeyExists($_form, $_what)
{    
    if ( $_POST[$_what] ) {
        return(true);
    } else {
        return(false);
    }
}

/*
 * <cfquery datasource="Entertainment">
 *  select *
 *  from Movies
 * </cfquery>
 * 
 * status: works
 * 
 */
function PF_query($i_sql, $i_datasource)
{
	global $g_con;
	global $g_DB_table;
	global $g_SQL_row;
	global $g_myFields;

    
	$res = mysqli_query($g_con, "$i_sql");
    
	// $res = mysql_query("$i_sql");
	if (!$res) {
		echo 'CF_query ERROR: ' . mysqli_error($g_con);
		return;
	}
    
    
    
	$g_SQL_row = mysqli_fetch_array($res, MYSQLI_ASSOC);
	//$g_SQL_row = mysql_fetch_array($res);  // obsolete
	
	//var_dump($g_SQL_row);


    //
    // -- get all fields in table
    //
    //$myFields = array();
    $sql = "SHOW COLUMNS FROM $g_DB_table";

	$result = mysqli_query($g_con, "$sql");
	//$result = mysql_query($sql);

    if (!$result) {
        echo "SQL:$sql";
        echo 'Konnte Abfrage nicht ausführen: ' . mysqli_error($g_con);
        die();
    }


	if (mysqli_num_rows($result) > 0) {
	
		while ($row2 = mysqli_fetch_assoc($result)) {
			
			//echo "<pre>";
			//var_dump($row2);
			//echo "</pre>";
			
			array_push($g_myFields, $row2['Field']);
		}
	}

}

// status: works
function PF_use_template($_filename, $_id)
{
// $_tbl

	global $g_con;
	global $g_DB_table;
	global $g_pf_vars;

    $file = file_get_contents($_filename, true);






	// <cfset variable_hello="Hallo World!">

	$data = array();

	/*
	$data[] = [
		"key" => "val"
	];
	var_dump($data);
	*/
			

	$howmany = 0;

	if ( ( $howmany = preg_match_all("/<cfset\s*(.*?)\s*=\s*(.*?)>/", $file, $matches, PREG_SET_ORDER) )  )
	{

		// cfset

		//echo "howmany: $howmany";

		/*
		echo "<hr><pre>";
		print_r($matches[0]);
		echo "</pre><hr>";

		echo "<hr><pre>";
		print_r($matches[1]);
		echo "</pre><hr>";
		*/

		for ($a=0; $a<$howmany; $a++) {

			if (  "$matches[$a][1]"  != "" ) {
				// store variable
				$key = $matches[$a][1];
				$val = $matches[$a][2];

				// remove (")
				$val = trim($val, '"');

				/*echo "<pre>";
				var_dump($key);
				var_dump($val);
				echo "</pre>";*/


				$data["$key"] = $val;

// 				$data[] = [
// 					"$key" => "$val"
// 				];
							
				//$data[] = array($key => $val);

			}

		}

		$g_pf_vars = $data;

		/*echo "<hr><pre>";
		var_dump($g_pf_vars);
		echo "</pre><hr>";*/


	}
	


	if ( ( $howmany = preg_match_all("/<cfif\s*(.*?)>(.*?)<\/cfif>/", $file, $matches, PREG_SET_ORDER) )  )
	{
	
		/*
		<cfif expression> 
		If....
		<cfelseif expression> 
		Else if...
		<cfelse> 
		Else...
		</cfif>
		*/
	
	
	}	






	$output = $file;

	foreach($g_pf_vars as $key => $val) {
		//echo "$key -> $val";
		//var_dump($val);
		$output = preg_replace("/#${key}#/", $val, $output);
	}








    $res = mysqli_query($g_con, "SELECT * from $g_DB_table WHERE id=$_id");  // $_tbl
    if (!$res) {
        echo 'Konnte Abfrage nicht ausführen: ' . mysqli_error($g_con);
        return;
    }
    
    $row = mysqli_fetch_array($res,MYSQLI_BOTH);

    /*echo "<pre>";
    print_r($row);
    echo "</pre>";*/
    
    
    
    
    
    
    //
    // -- get all fields in table
    //
    
    $myFields = array();
    $result = mysqli_query($g_con, "SHOW COLUMNS FROM $g_DB_table");
    if (!$result) {
        echo 'Konnte Abfrage nicht ausführen: ' . mysqli_error($g_con);
        exit;
    }    
    if (mysqli_num_rows($result) > 0) {
        while ($row2 = mysqli_fetch_assoc($result)) {
            array_push($myFields, $row2['Field']);
        }
    }


	//$output = $file;
	//echo $output;

	foreach ($myFields as $element) {

		$searchString = "#${element}#";
		//echo $searchString;
        
		$val = $row["${element}"];
		//echo "val=" . $val;

		$output = preg_replace("/$searchString/", $val, $output);
		//echo $output;
	}

	echo "$output";

}



function pf_loop_query($g_sql, $_tbl, $id1, $id2)
{
    
    global $g_con;
    
    $res = mysqli_query($g_con, $g_sql);

    while($row = mysqli_fetch_array($res, MYSQLI_BOTH)) {
        echo $row["$id1"] . " ";
        echo $row[$id2];
        echo "<br/>";
    }
            
}


// status: works

function PF_CSV_to_HTML_table($i_g_sql, $i_detail_text, $i_ID)
{

	global $g_con;
	global $g_DB_table;

    //echo "$i_g_sql";

    $result_data = mysqli_query($g_con, $i_g_sql);
    
    $myFields = array();


    $result = mysqli_query($g_con, "SHOW COLUMNS FROM $g_DB_table");	// -TODO:const g_DB_table catalogue
    if (!$result) {
        echo 'Konnte Abfrage nicht ausführen: ' . mysqli_error($g_con);
        exit;
    }

    echo '<table class="PF_table">';
    
    
    //
    // -- print head of table
    //
    
    echo '<tr>';
    

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
        
            array_push($myFields, $row['Field']);

            echo '<th>' . $row['Field'] . '</th>';                

            //print_r($row);
        }

        if ($i_detail_text != NULL) {
            echo '<th>' . $i_detail_text . '</th>';
        }
    }
    echo '</tr>';

    
	//echo "<pre>"; print_r($myFields);echo "</pre>";
    
    

    //
    // -- print data of table
    //
    
    $nf = mysqli_num_fields($result);
    //echo "nf: $nf";


    while($row_data = mysqli_fetch_array($result_data,MYSQLI_BOTH)) {
                
	//echo '<pre>';print_r($row_data);echo '</pre>';

        echo '<tr>';
        
        for ($n=0; $n<=$nf; $n++) {
            echo '<td>' . $row_data[ $n ] . '</td>';
        }
        
        if ($i_detail_text != NULL) {
            echo '<td><a href=' . $i_ID . $row_data['id'] . ">$i_detail_text</a>" . '</td>';
        }
        
        echo '</tr>';

    }    
    
    echo '</table>';
}


/*
 * HTML:
 * <input type="radio" name="size[]" value="0:0" checked> (all sizes)<br/>
 * <input type="radio" name="size[]" value="2:2"> 2 person<br/>
 * <input type="radio" name="size[]" value="4:4"> 4 person<br/>
 * <input type="radio" name="size[]" value="8:8"> 8 person<br/> 
 * 
 * or:
 *         <select name="consumption[]">
            <option value="0:0">(all)</option>
            <option value="0.0:6.1"> til 6.0 L</option>
            <option value="6.2:10.5"> ~10.0 L</option>
            <option value="11.5:12.5"> ~12.0 L</option>
            <option value="12.6:99"> &gt;12.0 L </option>
        </select>
 * 
 * 
 * 
 * SQL:
 * " AND ps BETWEEN 120 AND 190"
 */
function PF_HTML_radio_option_to_SQL($i_string_id)
{

    $val = $_POST[$i_string_id][0];
    $val_arr = explode(":", $val);
    
    $lower_range = $val_arr[0];
    $upper_range = $val_arr[1];

    /*echo "<xmp>";
    echo "lower_range=" . $lower_range . "\n";
    echo "upper_range=" . $upper_range . "\n";
    echo "</xmp>";*/

    if ( $lower_range == "0" && $upper_range == "0" ) {
        // default "All" -> no SQL
        $ret_val = " /* ${i_string_id}=0 */ \n";
    } else {
        $ret_val = " AND ${i_string_id} BETWEEN " . $lower_range . " AND " . $upper_range . "\n";
    }
    
    return($ret_val);
}

/* HTML: checkbox
 * Adds this to SQL string:
 *   " category IN ('A', 'B', 'C') "
 *   " greenlabel IN ('A','B') "
 *
 */
function PF_HTML_checkbox_to_SQL($i_string_id)
{
    //echo $i_string_id;
    //echo "Deb: " . $_POST[$i_string_id][0];

    if ( $_POST[$i_string_id][0] == "0" ) {
        // default "All" -> no SQL
        $ret_val = " /* ${i_string_id}=0 */ \n";
    } else {
        $ret_val = " AND $i_string_id IN (" . pf_singleQuote($_POST[$i_string_id]) . ") \n";
    }

    return($ret_val);
}

// $str_array = array('ab c', 'de f', 'ghi');
// echo "'" . implode("','", $str_array) . "'";
// status: works
function PF_singleQuote($i_array)
{
    if (isset($i_array)) {
        $ret_val = "'" . implode("','", $i_array) . "'";
        return($ret_val);
    } else {
        return("");
    }
}

function PF_getValue($i_array)
{
    if (isset($i_array)) {
        $ret_val = implode("", $i_array);
        return($ret_val);
    } else {
        return("");
    }
}
