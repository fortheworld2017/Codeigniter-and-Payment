<?php
	error_reporting(E_ALL);
	ob_start();
		if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
	require_once(ABS_PATH.'Controllers/MonitorController.php');
	$MonitorControllerObj = new MonitorController();
	if(isset($_POST['dayFilter']) || isset($_POST['fromDate'])){
		unset($_SESSION['dayFilter']);
		unset($_SESSION['monthFilter']);
		unset($_SESSION['yearFilter']);
		unset($_SESSION['fromDate']);
		unset($_SESSION['toDate']);
	}
	if(isset($_POST['dayFilter']) && $_POST['dayFilter'] == 1)
		$_SESSION['dayFilter'] = $_POST['dayFilter'];
	if(isset($_POST['monthFilter']) && $_POST['monthFilter'] == 1)
		$_SESSION['monthFilter'] = $_POST['monthFilter'];
	if(isset($_POST['yearFilter']) && $_POST['yearFilter'] == 1)
		$_SESSION['yearFilter'] = $_POST['yearFilter'];
	if(isset($_POST['fromDate']) && $_POST['fromDate'] != "")
		$_SESSION['fromDate'] = $_POST['fromDate'];
	if(isset($_POST['toDate']) && $_POST['toDate'] != "")
		$_SESSION['toDate'] = $_POST['toDate'];

	$field = $condition = $get_visit = $groupName = $cardName = '';
	$fetch_browser_array = $browser_color_array = $month_graph_value = $visit_time_array = $exit_array = $visit_array = $fetch_exit_array = $fetch_date_array = $browser_array = $fetch_visit_array = $bar_graph_value = $graph_browser_value = $graph_exit_value = $graph_time_value = $repeat_hour = $exit_color_array = $time_color_array = array();

	$color_array 		= array ("#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f","#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f");

	$time_color_array 	= array ("#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f","#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f");

	$time_color_array 	= array_keys($time_color_array);
	$total_visit		= 0;
	$today_date			= date('Y-m-d');

	/*	---------- card detail ----------	*/
	$fields			=	"g.id,g.groupName";
	$condition		=	" cg.fkUserId = ? ";
	$sub_busCard	=	$MonitorControllerObj->getSubBusinessCard($fields, $condition, array($_SESSION['tac_data']['user_id']));
	
	$firstGroup		= 	(array)$sub_busCard[0];
	$groupName 		=	$firstGroup['groupName'];
	$groupField		=	"cd.name, cd.modifiedDate, cd.id as cardid";
	$bindParams		=	array(); 

	if(isset($_GET['groupid']) && $_GET['groupid'] != '')
	{
		$groupCondition		= " g.id = ? and cd.checkoutStatus = 0 and cd.deletedStatus = 1 ";
		$bindParams[]		= $_GET['groupid'];
	}
	else
	{
		$groupCondition		= " g.id = ? and cd.checkoutStatus = 0 and cd.deletedStatus = 1 ";
		$bindParams[]		= $firstGroup['id'];
	}
	$cardName_arr 	=	$MonitorControllerObj->getCardNameByGroup($groupField,$groupCondition, $bindParams);

	$first_cardid	=	(array)$cardName_arr[0];
	$field			=	"*, DATE_FORMAT( browsedDate,'%m' ) as month ,DATE_FORMAT(browsedDate,'%H') as bTime";
	if(isset($first_cardid['cardid']) && $first_cardid['cardid'] != ''){
		$condition	= 	' and fkCardDetailsId = '.$first_cardid['cardid'];
	}
	if(isset($_GET['cardid']) && $_GET['cardid'] != ''){
		$condition		= 	' and fkCardDetailsId = '.$_GET['cardid'];
		$cardField		= 	" cd.cardname,g.groupName,g.id ";
		$cardCond 		= 	" cd.id=".$_GET['cardid']." and cd.checkoutStatus = 0 and cd.deletedStatus = 1 ";
		$cardNameAry 	= 	$MonitorControllerObj->getCardNameByGroup($cardField,$cardCond);
		$cardNameAry	= 	(array)$cardNameAry[0];
		$cardName		=	$cardNameAry['cardname'];
		$groupName		=	$cardNameAry['groupName'];
		$cond1 			=	" g.id=".$cardNameAry['id']." and cd.checkoutStatus = 0 and cd.deletedStatus = 1 "; 
		$cardName_arr 	=	$MonitorControllerObj->getCardNameByGroup($groupField,$cond1);
	}
	else{
		if(!isset($_POST['dayFilter'])){
			unset($_SESSION['dayFilter']);
			unset($_SESSION['monthFilter']);
			unset($_SESSION['yearFilter']);
			unset($_SESSION['fromDate']);
			unset($_SESSION['toDate']);
		}
	}
	if(isset($_SESSION['dayFilter']) && $_SESSION['dayFilter'] == 1)
		$condition	.= " and DATE_FORMAT( browsedDate,'%d' ) = DAYOFMONTH(CURRENT_DATE) ";
	else if(isset($_SESSION['monthFilter']) && $_SESSION['monthFilter'] == 1)
		$condition	.= " and DATE_FORMAT( browsedDate,'%m' ) = MONTH(CURRENT_DATE) ";
	else if(isset($_SESSION['yearFilter']) && $_SESSION['yearFilter'] == 1)
		$condition	.= " and DATE_FORMAT( browsedDate,'%Y' ) = YEAR(CURRENT_DATE) ";
	else if((isset($_SESSION['fromDate']) && $_SESSION['fromDate'] != "") && (isset($_SESSION['toDate']) && $_SESSION['toDate'] != "")) {
		$condition	.= " and browsedDate >= '".date("Y-m-d" , strtotime($_SESSION["fromDate"]))." 00:00:00' AND browsedDate <= '".date("Y-m-d" , strtotime($_SESSION["toDate"]))." 00:00:00'";
	}
	if( (isset($first_cardid['cardid']) && $first_cardid['cardid'] != '') || (isset($_GET['cardid']) && $_GET['cardid'] != '') )
		$get_visit = $MonitorControllerObj->getMonitorDetail($field,$condition);  //sitevisit
	// if($_SERVER['REMOTE_ADDR'] == '172.21.4.135') { echo "<pre>Line : ".__LINE__."<br>FILE : ".__FILE__."<br>"; print_r($get_visit); echo "</pre>"; }
	
	if(isset($get_visit) && is_array($get_visit) && count($get_visit)>0){
		foreach($get_visit as $key=>$value)
		{
			$fetch_visit_array[]		= 	$value->month;
			$fetch_date_array[]			= 	$value->bTime * 1;
			$fetch_browser_array[]		= 	$value->browser;
		}
		if($_SERVER['REMOTE_ADDR'] == '172.21.4.135') { echo "<pre>"; print_r($fetch_visit_array); echo "</pre>"; }
		if($_SERVER['REMOTE_ADDR'] == '172.21.4.135') { echo "<pre>"; print_r($fetch_date_array); echo "</pre>"; }
		if($_SERVER['REMOTE_ADDR'] == '172.21.4.135') { echo "<pre>"; print_r($fetch_browser_array); echo "</pre>"; }
	}
		$fetch_visit_array = array_count_values($fetch_visit_array);
	if(is_array($fetch_visit_array) && count($fetch_visit_array)>0)
	{
		foreach($fetch_visit_array as $key=>$value)
		{
			$visit_array[$key*1]	= $value;
			//$visit_array[$key-1]	= $value;
			$total_visit			= $total_visit + $value;
		}
		ksort($visit_array);
		foreach($visit_array as $key=>$value)
		{
			$bar_graph_value[]		=	$value;
			$month_graph_value[]	=	$key;
		}
	}
	if(is_array($fetch_browser_array) && count($fetch_browser_array)>0)
	{ 
		$browser_array = array_count_values($fetch_browser_array);
		ksort($browser_array);
		foreach($browser_array as $key=>$value)
		{
			$graph_browser_value[] = $value;
		}
	}
	if(is_array($fetch_exit_array) && count($fetch_exit_array)>0)
	{
		$exit_array = array_count_values($fetch_exit_array);
		ksort($exit_array);
		foreach($exit_array as $key=>$value)
		{
			$graph_exit_value[] = $value;
		}
	}
	if(is_array($fetch_date_array) && count($fetch_date_array)>0)
	{ 
		$visit_time_array = array_count_values($fetch_date_array);
		ksort($visit_time_array);
		foreach($visit_time_array as $key=>$value)
		{
			$graph_time_value[] = $value;
		}
	}
	function getArrayValues($array,$type) // $type-> 1)Total, 2)Percentage
	{
		switch($type)
		{
			case 1:
				$total = 0;
				if(is_array($array) && count($array)>0)
				{
					foreach($array  as $key=>$value)	{
						$total = $total+$value;
					}
				}
				else
				{
					$total = 0;
				}
				return $total;
			case 2:
				$percentage_array = array();
				$total = getArrayValues($array,1);
				if(is_array($array) && count($array)>0)
				{
					foreach($array  as $key=>$value){
						$percentage_array[$key] = ($value/$total)*100;
					}
				}
				else
				{
					$percentage_array = 0;
				}
				return $percentage_array;
		}
	}
	$percentage_browser_array = $percentage_exit_array = $percentage_time_day_array =  array();
	if(is_array($browser_array) && count($browser_array)>0)
	{
		$percentage_browser_array	= getArrayValues($browser_array,2);
		$browser_color_array		= array_keys($percentage_browser_array);
	}
	if(is_array($exit_array) && count($exit_array)>0)
	{
		$percentage_exit_array		= getArrayValues($exit_array,2);
		$exit_color_array			= array_keys($percentage_exit_array);
	}
	if(is_array($visit_time_array) && count($visit_time_array)>0)
	{
		$percentage_time_day_array	= getArrayValues($visit_time_array,2);
		$time_color_array			= array_keys($percentage_time_day_array);
	}
?>
	<?php siteHeader(); ?>
	<!-- Content : Start -->
	<div class="Bodycontent">
		<!-- Left nav : Start -->
		<?php leftNav();?>
		<!-- Left nav : End -->
		<div class="inner_container">
			<!-- Breadcrum : Start -->
			<?php  breadCrumb();  ?>
			<!-- Breadcrum : End -->
			<div class="content">
				<!-- Subnav : Start -->
				<div class="subnav" >
					<div class="cardmenu" style="display: block">
						<ul>
							<li class="busines_card_sel" onclick="changeCampaign('BUSINESS CARD');"><a href="javascript:void(0);" title="BUSINESS CARD" class="sel">BUSINESS CARD</a></li>
							<div>
								<ul>
									<?php 
									if(isset($sub_busCard) && count($sub_busCard) > 0 && is_array($sub_busCard)) {
									foreach($sub_busCard as $key => $value)
									{?>
									<li><a <?php if(isset($groupName) && $groupName == $value->groupName) { ?>class="sel" style="color:#F2EC06;" id="selMonitorGroup" name="<?php if($value->groupName !='') echo $value->groupName; ?>" <?php } ?> title="<?php echo $value->groupName; ?>" href="monitor?groupid=<?php echo $value->id?>"><?php if($value->groupName !='') echo displayText($value->groupName,12); ?></a></li>
									<?php } }?>
								</ul>
							</div>
							<li class="poster" onclick="changeCampaign('POSTER');"><a href="javascript:void(0);" title="POSTER">POSTER</a></li>
						</ul>
					</div>				
					<div class="clearh"></div>
				</div>
				<!-- Subnav : End -->
				<div id="rightnav"  class="graphs">
					<div class="prevarrow" onclick="prevBlock();" ><!--  onclick="showBlock();" -->
						<a href="javascript:void(0);" title="next"><img src="WebResources/Images/common/prev_arrow.png" width="16" height="16" alt="" style="display:none;"></a>
					</div>
					<div class="graphheight fleft">
						<div class="graphtop graphouter">
							<div id="master_settings" class="graphinner">
								<input type="Hidden" id="nav_count" name="nav_count" value="0">
								<input type="Hidden" id="from" value="<?php  if(isset($_SESSION['fromDate']) && $_SESSION['fromDate'] != "") { echo $_SESSION['fromDate']; } ?>" >
								<input type="Hidden" id="to" value="<?php  if(isset($_SESSION['toDate']) && $_SESSION['toDate'] != "") { echo $_SESSION['toDate']; } ?>" >
								<div class="sitevisit" id="sitevisitsout">
									<div class="whitetop">
										<div id="sitevisits">
											<canvas id="sitevisits_graph" width="165" height="150"></canvas>
										</div>
										<div class="title">SITE VISITS</div>
										<div style="text-align:center;">Total:<?php echo $total_visit; ?></div>
									</div>
									<div class="greybot">
										<ul>
											<?php foreach($visit_array as $key=>$value) { ?>
											<li><span style="float:left; width:20px; height:10px;background:<?php echo $color_array[$key]; ?>"></span><span style="width:50px;padding-left:6px;float:left;"><?php echo $month_array[$key]; ?></span> <span><?php echo $value; ?> VISIT(S)</span></li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<div class="browser">
									<div class="whitetop">
										<div id="browser" style="height:150px;"></div>
										<div class="title">BROWSERS</div>
									</div>
									<div class="greybot">
										<ul>
											<?php foreach($browser_name_array as $key=>$value) { ?>
											<li><span style="float:left; width:20px; height:10px;background:<?php echo $color_array[$key]; ?>"></span><span style=" padding-left: 6px;float:left;"><?php echo $browser_name_array[$key]; ?></span> <span><?php if(isset($percentage_browser_array[$key]) && $percentage_browser_array[$key]!=''){echo round($percentage_browser_array[$key]).'%';} else echo '-';?></span></li>
											<?php }  ?>
										</ul>
									</div>
								</div>
								<div class="exit_click">
									<div class="whitetop">
										<div id="exit_click" style="height:150px;"></div>
										<div class="title">EXIT CLICKS</div>
									</div>
									<div class="greybot">
										<ul>
											<?php foreach($exit_name_array as $key=>$value) { 
											?>
											<li><span style="float:left; width:20px; height:10px;background:<?php echo $color_array[$key]; ?>"></span><span style=" padding-left: 6px;float:left;"><?php echo $exit_name_array[$key]; ?></span> <span><?php if(isset($percentage_exit_array[$key]) && $percentage_exit_array[$key]!=''){echo $percentage_exit_array[$key].'%';} else echo '-';?></span></li>
											<?php }  ?>
										</ul>
									</div>							
								</div>
								<div class="time_of_day" id="timeofdelay" >
									<div class="whitetop">
										<div id="time_of_day" style="height:150px;"></div>
										<div class="title">TIME OF DAY</div>
									</div>
									<div class="greybot">
										<ul>
											<?php $curr_time = date('H');
											foreach($time_array as $key=>$value) { 
												/*if($value>$curr_time)
													break; */
											?>
											<li><span style="float:left; width:20px; height:10px;background:<?php echo $color_array[$key]; ?>"></span><span style=" padding-left: 6px;float:left;"><?php echo $time_array[$key]; ?></span> <span><?php if(isset($percentage_time_day_array[$key]) && $percentage_time_day_array[$key]!=''){ echo number_format((float)$percentage_time_day_array[$key], 2, '.', '').'%';} else echo '-';?></span></li>
											<?php } ?>
										</ul>
									</div>
								</div>			
								<div class="clearh"></div>
								<!-- Listing -->
							</div>
						</div>	
					</div>
					<div class="nextarrow" onclick="nextBlock();">
						<a href="javascript:void(0);" title="next"><img src="WebResources/Images/common/left_arrow.png" width="16" height="16" alt=""></a>
					</div>
					<div class="clearh"></div>
					<?php 
						if(isset($cardName_arr) && is_array($cardName_arr) && count($cardName_arr) > 0){ ?>
							<div class="campaignlist" style="display: block; margin-top: 10px;">
							<table cellpadding="0" cellspacing="0" align="center" border="0" width="100%" class="campaigntable">
								<tr>						    
									<th width="22%">Campaign Name </th>
									<th width="22%">Interactions <span class="sortarrow"><a href="#"><img src="WebResources/Images/common/downs_arrow.png" width="10" height="6" alt=""></a></span></th>
									<th width="25%"> Date Modified <span class="sortarrow"><a href="#"><img src="WebResources/Images/common/downs_arrow.png" width="10" height="6" alt=""></a></span></th>
									<th width="30%"></th>
								</tr>
								<?php 
								foreach($cardName_arr as $card_key => $card_val) { ?>
								<tr class="<?php if(($card_key % 2)==0) echo "row1"; else echo "row2"; ?>">
									<td class="first"><a href="monitor?cardid=<?php echo $card_val->cardid; ?>"><?php echo $card_val->name; ?></a></td>
									<td align="center"><a href="monitor?cardid=<?php echo $card_val->cardid; ?>">5234</a></td>
									<td align="center"><a href="monitor?cardid=<?php echo $card_val->cardid; ?>"><span><?php echo date('d/m/Y',strtotime($card_val->modifiedDate)); ?></span><span style="padding-left:5px"><?php echo date('h:m A',strtotime($card_val->modifiedDate)); ?></span></a></td>
									<td></td>
								</tr>	
							<?php	} ?>
							</table>					
						</div>
					<?php } else { ?>		
						<div style="height:50px;"></div>					
						<div align="center" class="error_msg" >No Card Found</div>
					<?php } ?>		
				</div>	
			</div>
		</div>
	</div>
	<div class="clearh"></div>
</div>
<?php siteFooter();// call siteFooter from template ?>
<script type="text/javascript">
	$(document).ready(function(){
		siteAnalysis();
		/*$(".time_of_day").show();
		$(".time_of_day").css("opacity","0");*/
		$(".greybot").mCustomScrollbar({
			scrollButtons:{
				enable:true
			}
		});
		/*$(".time_of_day").css("opacity","1");
		$(".time_of_day").hide();*/
	});
	
	
	/* Bar Chart  Starts*/
	var
		barSpacing = 5,
		barWidth = 10, 
		//cvHeight = 220,
		numYlabels = 12,
		xOffset = 0,
		maxVal;
		gWidth=550, 
		gHeight=200;
		// Graph variables
		var gValues = [];
		var gValues = <?php if(is_array($bar_graph_value) && count($bar_graph_value)>0) { echo json_encode($bar_graph_value);} else { echo '[]';} ?>;
		var mValues = <?php if(is_array($month_graph_value) && count($month_graph_value)>0) { echo json_encode($month_graph_value); } else { echo '[]';} ?>;
		var xLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		var yLabels = [];
		//var colors  = ["#FFDAB9", "#E6E6FA", "#E0FFFF","#bbddb3", "#1d8e04"];
		var colors  = ["#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f"]; 
		// Canvas Variables
		var cv, ctx;
		//grabValues();
		initCanvas();
		maxValues(gValues);
		drawXlabels();
		//drawYlabels(numYlabels);
		drawGraph();
	/* Bar Chart  Ends*/
	
	/* Pie Chart Starts*/
		var labels = new Array();
		var piechart_type = new Array();
			piechart_type = ["browser","exit_click","time_of_day"];
		var colors = new Array(); 
		var colors  = ["#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f","#0d6faf", "#8686be", "#82c3c3","#bbddb3", "#1d8e04","#e2f5b4", "#9edd08","#6d6b1b", "#faf406","#2a8d96", "#ea2507","#fbd4b7", "#f2700f"];
		var terminal = 360;
		var new_data =new Array();
		for(chart_category in piechart_type)
		{
			var curr_piechart_type = piechart_type[chart_category];
			var	data_val_curr_piechart_type = new Array();
			if(curr_piechart_type=="browser") {
				var data_val_curr_piechart_type = <?php if(is_array($graph_browser_value) && count($graph_browser_value)>0) { echo json_encode($graph_browser_value);} else { echo '[]';} ?>;
				var cValues = <?php if(is_array($browser_color_array) && count($browser_color_array)>0) { echo json_encode($browser_color_array); } else { echo '[]';} ?>;				
			}
			else if(curr_piechart_type == "exit_click") {
				var data_val_curr_piechart_type = <?php if(is_array($graph_exit_value) && count($graph_exit_value)>0) { echo json_encode($graph_exit_value);} else { echo '[]';}
 ?>;
 				var cValues = <?php if(is_array($exit_color_array) && count($exit_color_array)>0) { echo json_encode($exit_color_array); } else { echo '[]';} ?>;
			}
			else if(curr_piechart_type == "time_of_day") {
				var data_val_curr_piechart_type =<?php if(is_array($graph_time_value) && count($graph_time_value)>0) { echo json_encode($graph_time_value);} else { echo '[]';} ?>;
				var cValues = <?php if(is_array($time_color_array) && count($time_color_array)>0) { echo json_encode($time_color_array); } else { echo '[]';} ?>;
			}
			var count = data_val_curr_piechart_type.length;
			 
			var sum =0;
			var data =new Array();
			for(i in data_val_curr_piechart_type)
			{
				sum = 1* sum + parseInt(data_val_curr_piechart_type[i]);
			}
			for(i in data_val_curr_piechart_type)
			{
				data[i] = (parseInt(data_val_curr_piechart_type[i])/sum)*terminal;
				labels[i] = data[i]+'%';
				
			}
			if(count>0)
			{
				labelPieChart(piechart_type[chart_category]);
			}
		}		
	/* Pie Chart Ends*/
	
	 
	window.onresize = function(event) {
		siteAnalysis();
	}

/*$(function(){
	var startdate = $('#from').val();
	var enddate = $('#to').val();	
	$('#custom').daterangepicker({
		arrows:false,
		earliestDate: Date.parse(),
		closeOnSelect: false,
		datepickerOptions:
		{										 
			changeMonth: true,
			changeYear: true
		},
		onClose: function(){
			$('.ui-daterangepicker').css("display","block");
		},
		onOpen:function(){ 
			if(startdate != ''){
				$('.range-start').datepicker('setDate',Date.parse(startdate)); 
				$('.range-end').datepicker('setDate',Date.parse(enddate)); 
			}
		}
	});
	$('li.ui-helper-clearfix').click();
	$('ul.ui-widget-content').hide();
	$('.btnDone').click(function(){
		validateDateRange();
	});		
}); */
</script>
