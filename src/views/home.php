<html>
	<head>
		<meta charset="UTF-8">
		<title>CDR </title>
		<link rel="stylesheet" type="text/css" href="../res/theme/redmond/jquery-ui-1.9.2.custom.min.css">	
		<link rel="stylesheet" type="text/css" href="../res/theme/<?php echo $options->view ?>.css">
		<script src="../res/scripts/jquery-1.8.3.js"></script>
		<script src="../res/scripts/jquery-ui-1.9.2.custom.min.js"></script>	
		<script src="../res/scripts/date-range-selector.js"></script>
	</head>
	<body>
		<div class="header">
			<h1>CDR </h1>
		</div>
		<div id="main">
			<div id="date-report-selector">
				<h1>Generación de archivo</h1>
				<p>Generación de archivo de texto para la facturación de un periodo dado.</p>
				<form action="generarReporte" method="post">
					<label>Desde: </label>
					<input type="text" id="from" name="startDate"/>	
					<label>Hasta: </label>
					<input type="text" id="to" name="endDate"/>	
					<input type="submit" value="Generar"/>
				</form>
				<h1><?php if(!is_array($response)) echo @$response?></h1>	
			</div>			
		</div>
	
	</body>
</html>
