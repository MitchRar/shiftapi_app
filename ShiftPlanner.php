<?php
	//To avoid session/header error
	
	# require the ShiftPlanning SDK class
	require('/src/shiftplanning.php'); 
	
	/* set the developer key on class initialization */
	$shiftplanning = new shiftplanning(
		array('key' => 'edd8008f3521cde7ee88ec1661cdce0f193b5d18')
		);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ShiftPlanning test</title>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap/3.3.7/css/bootstrap.min.css" />
	</head>
	<body>
	
	<?php
		$session = $shiftplanning->getSession( );
		/* echo "appKey: " . $shiftplanning->getAppKey( ) . "<br/>";		returns the developer key currently set
			
		echo "appToken: " . $shiftplanning->getAppToken( ) . "<br/>";	returns the token for the current session, error if not yet set*/
		if( !$session )
		{// if a session hasn't been started, create one
			// perform a single API call to authenticate a user
			$response = $shiftplanning->doLogin(
				array(// these fields are required to login
					'username' => 'milanrudez',
					'password' => 'SamODAProbaM',
					)
				);
			if( $response['status']['code'] !== 1 )
			{// display the login error to the user
				echo $response['status']['text'] . "--" . $response['status']['error'];
			}
		}
	?>

	<?php
	// attempting to fetch shifts

		$response = $shiftplanning->setRequest(
			array(
				'module' => 'schedule.shifts',
				'start_date' => 'Sep 5, 2016',
				'end_date' => 'Sep 9, 2016',
				'mode' => 'overview'
				)
			);
		$shifts = $shiftplanning->getResponse(0);
		// echo "Get Schedules Response: " . $get_schedules['status']['text'] . "<br/>"; Checking if data retrived

		
print <<<EOL
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>
			<center>ID</center> 
			</th>
			<th>
			<center>Full Name</center>  
			</th>
			<th>
			<center>Schedule Name</center>  
			</th>
			<th>
			<center>Started working</center>  
			</th>
			<th>
			<center>Shift starts</center>  
			</th>
			<th>
			<center>Shift ends</center>  
			</th>
		</tr>
	</thead>
		
EOL;

				foreach ($shifts['data'] as $row) 
				{//iterating through the asso_array
					
					// var_dump($row); to print out the data and locate the appropriate arrays needed
					
					print "<tr>";
					
					print "<td>{$row['id']}</td>";
					print "<td>".$row['employees']['0'] ['name']."</td>";
					print "<td>{$row['schedule_name']}</td>";
					print "<td>".$row['start_date']['formatted']."</td>";
					print "<td>".$row['start_date']['time']."</td>";
					print "<td>".$row['end_date']['time']."</td>";					
					
					print "</tr>";
				}
				
print "</table>";?>
	
	</body>
</html>