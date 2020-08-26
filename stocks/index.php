<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");

$tax = 0.04;
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - stocks</title>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <script>function onLogin(token){ document.getElementById('submitform').submit(); }</script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        var chart;

        function drawChart() {

            chart = new google.visualization.PieChart(document.getElementById('piechart'));

            refChart();
        }

        function refChart() {
            var xmlhttp;

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var dataArray = new Array();
                    var jsonData = JSON.parse(this.responseText);
                    for(var i in jsonData){
                        dataArray.push([i,jsonData[i]]);
                    }

                    var data = google.visualization.arrayToDataTable(dataArray);

                    var options = {
                        title: 'Cash'
                    };

                    chart.draw(data, options);
                }
            }

            xmlhttp.open("get", "/stocks/api/investors.php");
            xmlhttp.send();

            setTimeout(()=>{
                refChart();
            },10000)
        }
        </script>

		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php"); ?>
            <h1>stocks</h1>
            welcome to the (totally) very predictable virtual stock market where you can dump money and lose hundreds of bobux<br><small>DO NOT TAKE THIS SERIOUSLY!!!!</small>
            <br><br>
            <form method="get" action="buy">
				<fieldset>
					Buy: <input required placeholder="Stock Name" type="text" name="name"> <input required placeholder="Amount" type="number" name="amount"> <input type="submit" value="Buy">
				</fieldset>
            </form><hr>
            <h2 style="margin: 0px;">owned stocks</h2>
            <?php 
                $stmt = $conn->prepare("SELECT * FROM stocks WHERE owner = ?");
                $stmt->bind_param("s", $_SESSION['user']);
                $stmt->execute();
                $result = $stmt->get_result();
            
                while($row = $result->fetch_assoc()) { 
                    echo "<b>" . $row['amount'] . "</b> of <b>" . $row['stockname'] . "</b> | <a href='sell?id=" . $row['id'] . "'>Sell</a><br>";
                }
            ?>
            <hr>
            <br>You have <?php if(isset($_SESSION['user'])) { echo "<b>" . getBobux($_SESSION['user'], $conn) . "</b> Bobux"; } else { echo "Not Logged in"; } ?><br><b>Current Tax Rate:</b> <?php echo $tax; ?> * Price of Stock<br>
            You must input their corporate name, for example: BBUX = Bobux Inc.<br><br>
            <?php 
                $stmt = $conn->prepare("SELECT * FROM stocknames");
                $stmt->execute();
                $result = $stmt->get_result();
            
                while($row = $result->fetch_assoc()) { 
                    $finalTax = $row['price'] * $tax;
                    echo '<b>[' . $row['coname'] . '] ' . $row['name'] . '[' . $row['price'] . ' <img src="/static/img/silk/money.png"> + ' . $finalTax . ' <img src="/static/img/silk/money.png">]</b><br>';
                }
            ?>
            <hr>
            <div id="piechart" style="width: 768px; height: 500px;"></div>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>