<?php 
// Variables
$notGivenCoupons=$givenCoupons-$usedCoupons; 
$guestCustomers=$totalCustomers-$registeredCustomers;
?>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});

function drawChartCoupons() {
	var data = google.visualization.arrayToDataTable([
	  ['Type', 'Count'],
	  ['Used coupons',	<?php echo $usedCoupons; ?>],
	  ['Not used coupons',	<?php echo $notGivenCoupons; ?>]
	]);
	var options = {
	  title: 'Total coupons: <?php echo $givenCoupons; ?>',
	  backgroundColor: 'transparent',
	  height: '350',
	  is3D: true,
	  chartArea: {top:50,bottom:0,width:'100%'}
	};
	var chart = new google.visualization.PieChart(document.getElementById('chartCoupons'));
	chart.draw(data, options);
}

function drawChartCustomers() {
	var data = google.visualization.arrayToDataTable([
	  ['Type', 'Count'],
	  ['Registered customers',	<?php echo $registeredCustomers; ?>],
	  ['Guest customers',	<?php echo $guestCustomers; ?>]
	]);
	var options = {
	  title: 'Total abandoned carts: <?php echo $totalCustomers; ?>',
	  backgroundColor: 'transparent',
	  height: '350',
	  is3D: true,
	  chartArea: {top:50,bottom:0,width:'100%'}
	};
	var chart = new google.visualization.PieChart(document.getElementById('chartCustomers'));
	chart.draw(data, options);
}

if (typeof drawChartCoupons == 'function') { 
    google.setOnLoadCallback(drawChartCoupons);
}
if (typeof drawChartCustomers == 'function') { 
    google.setOnLoadCallback(drawChartCustomers);
}

$('a[href=#analytics]').on('click', function() {
	if (typeof drawChartCoupons == 'function') { 
		setTimeout(function() { drawChartCoupons(); }, 100);
	}
	if (typeof drawChartCustomers == 'function') { 
		setTimeout(function() { drawChartCustomers(); }, 100);
	}
});

$(window).resize(function(){
	drawChartCoupons();
	drawChartCustomers();
});
</script>
<div class="row-fluid">
  <div class="col-xs-6">
	<div id="chartCoupons" class="well" style="height:300px;overflow:hidden;"></div>
	<div id="chartCustomers" class="well" style="height:300px;overflow:hidden;"></div>
  </div>
  <div class="col-xs-6">
    <table class="table-hover table table-striped">
        <thead>
            <tr>
                <th width="70%">Coupons</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa fa-gift"></i> Total coupons</td>
                <td><?php echo $givenCoupons; ?></td>
            </tr>
            <tr>
                <td><i class="fa fa-ticket"></i> Not used coupons</td>
                <td><?php echo $notGivenCoupons; ?></td>
            </tr>
            <tr>
                <td><i class="fa fa-check-square-o"></i> Used coupons</td>
                <td><?php echo $usedCoupons; ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table-hover table table-striped">
        <thead>
            <tr>
                <th width="70%">Abandoned carts</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa fa-list-alt"></i> Total carts</td>
                <td><?php echo $totalCustomers; ?></td>
            </tr>
            <tr>
                <td><i class="fa fa-eye"></i> Registered customers</td>
                <td><?php echo $registeredCustomers; ?></td>
            </tr>
            <tr>
                <td><i class="fa fa-eye-slash"></i> Guest customers</td>
                <td><?php echo $guestCustomers; ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table-hover table table-striped">
        <thead>
            <tr>
                <th width="70%">Last visited pages</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mostVisitedPages as $result) { ?>
            <tr>
                <td><i class="fa fa-file"></i> <?php echo "...".substr($result['last_page'], -45); ?></td>
                <td><?php echo $result['count']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>  
  </div>
</div>
<br />