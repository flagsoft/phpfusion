<?

include_once("pf_core.php");

PF_DB_connect("localhost", "<your-database-name>", "<your-database-password>");
PF_DB_select("<your-database-name>");
PF_DB_table("catalogue");

$ID=$_GET['id'];

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="pf_style.css" />
        <!-- <link rel="stylesheet" type="text/css" href="car_detail.css" /> -->
    </head>
<body>
    
    
    <a href="index.html">Search</a>

    
    <h2>Catalogue Detail</h2>
    

    <? PF_query("SELECT * FROM catalogue WHERE id=$ID", NULL); ?>
    
    <table class="detail">
        <tr>
            <td>Id:</td>
            <td>#id#</td>
        </tr>
        <tr>
            <td>Number of Seats:</td>
            <td>#size#</td>
        </tr>
        <tr>
            <td>Car Brand:</td>
            <td>#carbrand#</td>
        </tr>

        <tr>
            <td>Consumption:</td>
            <td>#consumption#</td>
        </tr>

        <tr>
            <td>Green Label:</td>
            <td>#greenlabel#</td>
        </tr>
        
    </table>

</body>
</html>
<? PF_DB_close(); ?>
<? ob_end_flush();
