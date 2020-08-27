<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
require($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

$tax = 0.04;
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - profile</title>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <script>function onLogin(token){ document.getElementById('submitform').submit(); }</script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['User', 'Money'],
                <?php
                    $stmt = $conn->prepare("SELECT bobux, username FROM users");
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    while($row = $result->fetch_assoc()) { 
                        echo "['" . $row['username'] . "', " . $row['bobux'] . "]," . PHP_EOL;
                    }
                ?>
                ['',     0]
            ]);

            var options = {
                title: 'Cash'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
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
            You must input their corperate name, for example: BBUX = Bobux Inc.<br><br>
            <?php 
                $stmt = $conn->prepare("SELECT * FROM stocknames");
                $stmt->execute();
                $result = $stmt->get_result();
            
                while($row = $result->fetch_assoc()) { 
                    $finalTax = $row['price'] * $tax;
                    echo '<b>[' . $row['coname'] . '] ' . $row['name'] . '</b> <b>[' . $row['price'] . ' <img src="/static/img/silk/money.png"> + ' . $finalTax . ' <img src="/static/img/silk/money.png">]</b><br>';
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