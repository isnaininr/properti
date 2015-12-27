<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!--NAVBAR-->
	<div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse navbar-right scroll-me">
                <ul class="nav navbar-nav ">
                    <li>
						<?php
						mysql_connect("localhost", "root","") or die(mysql_error());
						mysql_select_db("basisdata") or die(mysql_error());
						$query = "SELECT * FROM properti ORDER BY id_properti";
						$result = mysql_query($query) or die(mysql_error()."[".$query."]");?>
						
						<form action="" method="POST">
						<select name="properti" class="form-control">
							<?php while ($row = mysql_fetch_array($result)){
							?>
							   <option value=" <?php $row['id_properti']; ?> ">
								 <?php echo $row['nama_properti']; ?>
								</option>
							<?php
							}
							?>        
						</select>
						
					</li>
					<li>
					<input type="SUBMIT" value="Submit" name="submit"  class="btn btn-info">
						</form>
					</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- NAVBAR CODE END -->
</body>
</html>