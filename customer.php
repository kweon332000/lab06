<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php
			if ($_POST["card"] == "Visa") {
					$r="/^4[0-9]{15}/";
			}
			elseif($_POST["card"]=="Mastercard"){
					$r="/^5[0-9]{15}/";
			}
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (!isset($_POST["name"]) || empty($_POST["name"])
				|| !isset($_POST["number"]) || empty($_POST["number"])
				|| !isset($_POST["fruit"]) || empty($_POST["fruit"])
				|| !isset($_POST["fruits"]) || empty($_POST["fruits"])
				|| !isset($_POST["quantity"]) || empty($_POST["quantity"])
				|| !isset($_POST["credit"]) || empty($_POST["credit"])
				|| !isset($_POST["card"]) || empty($_POST["card"])) {
		?>
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. <a href="fruitstore.html">Try again?</a></p>

		<?php
				} else if (!preg_match("/^[a-zA-Z]*[\ \-]?[a-zA-Z]*$/",$_POST["name"])) { 
		?>


			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="fruitstore.html">Try again?</a></p>

		<?php

				} else if (!preg_match($r, $_POST["credit"])) {
		?>

			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="fruitstore.html">Try again?</a></p>

		<?php

		} else {
		?>

		<h1>Thanks!</h1>
		<p>Your information has been recorded.</p>

		<ul> 
			<li>Name: <?= $_POST["name"] ?></li>
			<li>Membership Number: <?= $_POST["number"] ?></li>
			<li>Options: <?= processCB($_POST["fruit"]) ?></li>
			<li>Fruits: <?= $_POST["fruits"]." - ".$_POST["quantity"] ?></li>
			<li>Credit <?= $_POST["credit"]." (".$_POST["card"].")" ?></li>
		</ul>
		
			<p>This is the sold fruits count list:</p>
		<?php
			$filename = "customers.txt";

			 file_put_contents($filename, $_POST["name"].";".$_POST["number"].";".$_POST["fruits"].";".$_POST["quantity"]."\n", FILE_APPEND);
		?>
		

		<ul>
		<?php 
		$counts = CountFruit($filename);
		foreach($counts as $line) {
			
		?>
			<li><?= $line ?></li>
		<?php
		}
		?>
		</ul>
		
		<?php
		}}
		?>
		
		<?php

			function CountFruit($filename) {
				$result = array(0, 0, 0, 0);
				$lines = file($filename);
				foreach($lines as $line) {
					$tmp = explode(";", $line);
					if ($tmp[2] == "Melon") {
						$result[0] += $tmp[3]; 
					}else if ($tmp[2] == "Apple") {
						$result[1] += $tmp[3];
					}else if ($tmp[2] == "Orange") {
						$result[2] += $tmp[3];
					}else if ($tmp[2] == "Strawberry") {
						$result[3] += $tmp[3];
					}
				}
				return array("Melon - ".$result[0], "Apple - ".$result[1], "Oragne - ".$result[2], "Strawberry - ".$result[3]);
			}
			function processCB($names) {
				$x = count($names) - 1;
				foreach ($names as $name) {
					$option = $option . $name;
					if ($x > 0) {
						$option = $option . ", ";
						$x--;
					}
				}
				return $option;
			}
		?>
		
	</body>
</html>
