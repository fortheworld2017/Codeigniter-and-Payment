<?php //test
	//session_destroy();
	session_start();
	global $tableName;
	global $fieldnames;
	global $result;
	global $perpage;
	global $db_conn;
	$query2	=	'';
	
	if(!isset($_SERVER['TFY_TEST_ENV']) || $_SERVER['TFY_TEST_ENV'] != 1)
		header('Location:home');
	
	if($_SERVER['HTTP_HOST'] != $_SERVER['TFY_TEST_IP_ADDR']){
		if(isset($_POST['test_submit']))
		{
			$test_user_name = trim($_POST['test_user_name']);
			$test_password = trim($_POST['test_password']);
			if($test_user_name == 'tactify' && $test_password == 'betauser')
			{
				$_SESSION['ses_test_user_name'] = 'tactify';
				$_SESSION['ses_test_password'] = 'betauser';
				header('Location:home');
			}
		}
		if(!isset($_SESSION['ses_test_user_name']) || !isset($_SESSION['ses_test_user_name']))
		{	
			include('Views/login_screen.php');
			die();
		}
	}
	
	if($_SERVER['SERVER_ADDR'] == $_SERVER['TFY_TEST_IP_ADDR'] )
	{
		// mysql_connect("localhost","root","dbpass") or die('Error in connecting MySQL');
		// $db_conn = mysql_select_db("tactify");
		$db_conn = mysqli_connect("localhost","root","dbpass","tactify",3306) or die('Error in connecting MySQL');
	}
	else
	{
		$mysql_server = 'aa1ctdglt33e33u.ctjbugikat2m.us-west-2.rds.amazonaws.com';
		$mysql_user   = 'tactify';
		$mysql_pass   = 'T1a2c3t4i5f6Y';
		$mysql_name   = 'tactify';
		// mysql_connect($mysql_server,$mysql_user,$mysql_pass) or die('Error in connecting MySQL');
		// $db_conn = mysql_select_db($mysql_name) or die('Error in selecting database MySQL');
		$db_conn = mysqli_connect($mysql_server,$mysql_user,$mysql_pass,$mysql_name,3306) or die('Error in connecting MySQL');
		
		if(mysqli_connect_errno()){
		  echo mysqli_connect_error();
		}

	}

	function destroySession()
	{
		unset($_SESSION["table"]);
		unset($_SESSION["query"]);
		unset($_SESSION["orderBy"]);
		unset($_SESSION["per_page"]);
		unset($_SESSION["total"]);
	}

	function getFieldName($result)
	{
		$fieldnames = array(); 
		
		while ($field = $result->fetch_field()) 
		{
			$fieldnames[] = $field->name; 
		}
	
        return $fieldnames;
	}
	
	function &executeQuery($query)
	{
		global $db_conn;
		
		$stmt  = mysqli_prepare($db_conn, $query);
		mysqli_stmt_execute($stmt);
		
		$result = $stmt->get_result();
		
		return $result;

	}

	function &paginationControl($start,$page,$query)
	{
		global $fieldnames;
		global $perpage;
		global $tableName;
		global $db_conn;
		
		$_SESSION['per_page'] = $page;
		$total = $_SESSION['total'];
		$tableName = 1;
		
		$query = $query.' order by id '.$_SESSION['orderBy'].' LIMIT '.$start.','. $page;
		$result =& executeQuery($query);
		$fieldnames = getFieldName($result);
		
		$_SESSION['pagination'] = 'false';
		if($total > $page)
		{
			$_SESSION['pagination'] = 'true';
			$perpage = ceil($total/$page);
		}
		
		return $result;
	}

	if(!isset($_POST['submit']) && !isset($_POST['per_page']) && !isset($_POST['cur_page']))
		destroySession();
	$tableName = '';
	if(isset($_POST['Submit']) && ($_POST['table'] != '' || $_POST['query'] != ''))
	{
		if($_POST['query'] == '')
		{
			$query = 'select * from `'.$_POST['table'].'` where 1 ';
			$_SESSION['query']	 = $query;
			$_SESSION['table']	 = $_POST['table'];
			$_SESSION['orderBy'] = $_POST['order'];
			
		}
		else
		{
			$query = $_POST['query'];
			$_SESSION['query'] = $query;
			$_SESSION['orderBy'] = $_POST['order'];
			
			if(strpos($query,'domainDetails') != false)
			    $_SESSION['table'] = 'domainDetails';
		}
		
		$count =& executeQuery($query);
		$total = $count->num_rows;
		
		if(strtolower(substr($query, 0 ,6)) == 'update') {
			$query = 'select * from `domainDetails` where 1 ';
			$_SESSION['query'] = $query;
			
			$count =& executeQuery($query);
			$total = $count->num_rows;
		}
		$_SESSION['total'] = $total;
		
		$result =& paginationControl(0, 10, $query);
	}
	
	if(isset($_POST['per_page']) || $_POST['cur_page'] )
	{
		$start	= ($_POST['cur_page']-1) * $_POST['per_page'];
		if($_POST['per_page'] == '')
			$page	=	10;
		else
			$page	=	$_POST['per_page'];
		paginationControl($start,$page);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Form</title>
	<style type="text/css">
		.bor {
			border:1px solid black;
			border-collapse:collapse;
		}
	</style>
</head>

<body>
<h1 align="center">DATA</h1>
<table align="center" class="bor">
	<form name="" id="" action="" method="post">
		<tr>
			<td>Select table:</td>
			<td width="45%">
				<select name="table" id="table" onchange="clearQuery();">
					<option value="">Select</option>
					<option value="domainDetails" <?php if(isset($_SESSION['table']) && $_SESSION['table'] == 'domainDetails') echo 'selected="selected"'; else echo '';?>>Domain Details</option>
					<option value="cardDetails" <?php if(isset($_SESSION['table']) && $_SESSION['table'] == 'cardDetails') echo 'selected="selected"'; else echo '';?>>Card Details</option>
				</select>
			</td>
			<td>Query:</td>
			<td><textarea rows="2" cols="25" name="query" id="query" value=""><?php if(isset($_SESSION['query'])) echo $_SESSION['query']; else echo '';?></textarea></td>
		</tr>
		<tr>
			<td>Order By:</td>
			<td>
				<select id="order" name="order">
					<option value="asc" <?php if(isset($_SESSION['table']) && $_SESSION['orderBy'] == 'asc') echo 'selected="selected"'; else echo '';?>>Asc</option>
					<option value="desc" <?php if(isset($_SESSION['table']) && $_SESSION['orderBy'] == 'desc') echo 'selected="selected"'; else echo '';?>>Desc</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<input type="submit" name="Submit" id="Submit" value="Submit" tabindex="1"/>
			</td>
		</tr>
		</form>
</table>
<h3><span>RECORDS:</span></h3><br>
<table align="center">
	<tr>
	<?php
	if(isset($_POST['per_page']) || isset($_POST['Submit']) && $_SESSION['pagination'] =='true' && $tableName != '')
	{
		for($i=1;$i<=$perpage;$i++) { ?>
		<td><a href="javascript:void(0);" onclick="setPagingControlValues('<?php echo $i;?>');"><?php echo $i;?></a></td>
	<?php } } ?>
	</tr>
</table>
<?php
	if($tableName != '') { ?>
	<p align="center"><?php echo strtoupper($_SESSION['table']); ?></p>
	<table border="1" width="50%" align="center" class="bor">
		<tr>
			<?php foreach($fieldnames as $value) { ?>
		       <th><?php echo $value; ?></th> 
		    <?php }	?>
		</tr>
		<?php
		 while($row = $result->fetch_assoc()) { ?>
		<tr>
			<?php foreach($fieldnames as $value) { ?>
		       <td align="center"><?php echo $row[$value]; ?></td> 
		    <?php }	?>
		</tr>
		<?php } ?>
	</table><br><br>
<?php } ?>

<?php if(isset($_POST['per_page']) || isset($_POST['Submit']) && $_SESSION['pagination'] =='true' && $tableName != '') { ?>
	<table align="center" width="50%">
		<form name="paging" id="paging" method="post" action="">
		<input type="Hidden" id="cur_page" name="cur_page" value="1">
		<tr>
			<td>Per Page:
			<select id="per_page" name="per_page" onchange="setPerPage(this.value);">
					<option value="5" <?php if($_SESSION['per_page'] == 5) echo 'selected="selected"'; else echo '';?>>5</option>
					<option value="10" <?php if($_SESSION['per_page'] == 10) echo 'selected="selected"'; else echo '';?>>10</option>
					<option value="20" <?php if($_SESSION['per_page'] == 20) echo 'selected="selected"'; else echo '';?>>20</option>
					<option value="30" <?php if($_SESSION['per_page'] == 30) echo 'selected="selected"'; else echo '';?>>30</option>
			</select>
			</td>
		</tr>
		</form>
	</table>
<?php } ?>
</body>
</html>
<script src="WebResources/Scripts/Jquery/jquery-1.7.min.js" type="text/javascript"></script>
<script>
function setPerPage(obj)
{
	$("#per_page").val(obj);
	$("#paging").submit();
}
function setPagingControlValues(cur_page)
{
	$("#cur_page").val(cur_page)
	$("#paging").submit();
}
function clearQuery()
{
	$('#query').val('');
}
</script>