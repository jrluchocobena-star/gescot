<?php
/* vim:ts=4:sts=4:sw=2:noai:noexportab
 *
 * Example server side script for autocomplete.
 */

header('Content-Type: text/html; charset=UTF-8');

/* iframe flag */
$i = array_key_exists('i', $_REQUEST) ? trim($_REQUEST['i']) : null;


if ($i != null)
	print <<<MOO
<html>
<body>
<script language="JavaScript">
<!--

MOO;

/* check for frame */
print <<<MOO
var moo = (parent._ac_rpc!=null)?parent:window;

MOO;

/* reference id */
$id = array_key_exists('id', $_REQUEST) ? trim($_REQUEST['id']) : null;

/* search query */
$s = array_key_exists('s', $_REQUEST) ? trim($_REQUEST['s']) : null;

$t = array_key_exists('t', $_REQUEST) ? trim($_REQUEST['t']) : null;

switch ($t) {
	case 'tecnico':	search_personal($id,$s);break;
	case 'vendedor': search_codigo($id,$s); break;  //vendedor dr speedy
	default: break;
}



if ($i != null)
	print <<<MOO

// -->
</script>
</body>
</html>

MOO;

function search_personal($id,$s) {
	print "moo._ac_rpc('$id'";
	$id_empresa=substr($id,7,3);

	$hostname_ObjConn = "localhost";
	$database_ObjConn = "COT";
	$username_ObjConn = "root";
	$password_ObjConn = "";
	$ObjConn = mysql_connect($hostname_ObjConn, $username_ObjConn, $password_ObjConn) or die(mysql_error());
	mysql_select_db($database_ObjConn, $ObjConn)or die("Error".mysql_error());


	$SQL="SELECT concat(cip,' - ',ncompleto) FROM tb_usuarios where ncompleto Like '%$s%'";		
	

	$res = mysql_query($SQL);
	$row = mysql_fetch_array($res);
	do{
		print ',"'.$row[0].'","'.$row[1].'"';
		if ($i++ > 10)
				break;
    }
    while($row = mysql_fetch_array($res));
	print ");\n";
}

function search_codigo($id,$s) { // Vendedor Dr Speedy
	print "moo._ac_rpc('$id'";
	$hostname_ObjConn = "localhost";
	$database_ObjConn = "cot";
	$username_ObjConn = "root";
	$password_ObjConn = "";
	$ObjConn = mysql_connect($hostname_ObjConn, $username_ObjConn, $password_ObjConn) or die(mysql_error());
	mysql_select_db($database_ObjConn, $ObjConn)or die("Error".mysql_error());
	$SQL="SELECT concat(cip,' - ',ncompleto) FROM tb_personal where ncompleto Like '%$s%' or cip Like '%$s%' order by ncompleto asc"; 

	$res = mysql_query($SQL);
	$row = mysql_fetch_array($res);
	do{
		print ',"'.$row[0].'","'.$row[1].'"';
		if ($i++ > 10)
				break;
    }
    while($row = mysql_fetch_array($res));
	print ");\n";
}

?>

