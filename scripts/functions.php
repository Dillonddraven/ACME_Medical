<?php

function pdo_connect_mysql() {
    @include_once ('../app_config.php');    
    try {
    	return new PDO(DSN1.';charset=utf8', USER1, PASSWD1);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
    @include_once ('../app_config.php'); 
    echo'
    <!DOCTYPE html>
    <html>
	   <head>
		<meta charset="utf-8">
		<title>Patient Portal</title>
		<link href="'.WEB_ROOT.APP_FOLDER_NAME.'/styles/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	   </head>
	   <body>
            <nav class="navtop">
    	       <div>
    		      <h1>Patient Portal</h1>
                  <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/landingPage.php"><i class="fas fa-home"></i>Home</a>
    		      <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/patients_table/patients_read.php"><i class="fas fa-user-injured"></i>Patients</a>
				  <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/doctors_table/doctors_read.php"><i class="fas fa-user-md"></i>Doctors</a>
				  <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/medications_table/medications_read.php"><i class="fas fa-tablets"></i>Medications</a>
				  <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/prescriptions_table/prescriptions_read.php"><i class="fas fa-medkit"></i>Prescriptions</a>
				  <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/visits_table/visits_read.php"><i class="fas fa-microscope"></i>Visits</a>
				  <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/fev1s_table/fev1s_read.php"><i class="fas fa-file-medical-alt"></i>FEV1s</a>
				</div>
            </nav>
';
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>