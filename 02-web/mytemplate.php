<div>
This is where mytemplate.php begins.


<h2>CFML (ColdFusion Markup Language)</h2>


<h3>cfoutput</h3>

Input:
<div>
<xmp><cfoutput>Welcome to PhpFusion, seriously.</cfoutput></xmp>
</div>

Output:
<div>
<cfoutput>Welcome to PhpFusion, seriously.</cfoutput>
</div>

<h3>cfset</h3>

Input:
<pre>
&lt;cfset variable_hello = "Hallo Welt!"&gt;
&lt;cfoutput&gt;Hi! &num;variable_hello&num;&lt;/cfoutput&gt;
</pre>

Output:
<div>
<cfset variable_hello = "Hallo Welt!">
<cfoutput>Hi! #variable_hello#</cfoutput>
</div>


<hr>

<cfset tempvar = 8>
<cfoutput>#tempvar#</cfoutput>

<hr>

<cfset variable_hello_2 = "Hallo Welt 2!">
<cfoutput>#variable_hello_2#</cfoutput>

<hr>

<cfif expression> 
if....
<cfelseif expression> 
else if....
<cfelse> 
else...
</cfif>

<hr>


<h3>cfloop (DRAFT)</h3>

<table border="4">

<cfloop query="getMyFriends">
    <tr>
        <td>#id#</td>
        <td>#carbrand#</td>
        </tr>
</cfloop>

</table>



<table border="1">

	<tr>
		<td>Id:</td><td>#id#</td>
	<tr>

	<tr>
		<td>Size:</td><td>#size#</td>
	</tr>

	<tr>
		<td>Car Brand:</td>
		<td>#carbrand#</td>
	<tr>

	<tr>
		<td>PS:</td>
		<td>#ps#</td>
	<tr>

	<tr>
		<td>Consumption:</td>
		<td>#consumption#</td>
	<tr>

	<tr>
		<td>Green Label:</td>
		<td>#greenlabel#</td>
	<tr>

</table>


This is where mytemplate.php ends.
</div>
