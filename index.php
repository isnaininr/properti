<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php 
	include "connection.php";
?>
	<div class="section">
		<div class="wrapper">

			<div class="row">
				<div class="col-md-12">					
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
								<li><a href="add.php"><img src="img/tambah.png" style="width: 35px; margin:5px 15px 0 0; float:right;"></a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- NAVBAR CODE END -->					
				</div>
				<div class="col-md-12">
			<br><br><br>
			<div class="row">
			<?php 
			$qry = mysqli_query($con, "SELECT * FROM kategori");
			$i=1;
			while($row = mysqli_fetch_array($qry)){
			 ?>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading turqoise"><?php echo $row['nama_kategori'] ?> 
						</div>
						<div class="panel-body">
							<ul>
							<?php 
								$qry1 = mysqli_query($con, "
								SELECT * FROM properti, kategori 
								WHERE properti.id_kategori = kategori.id_kategori AND properti.id_kategori=$row[id_kategori]");
								while($row2= mysqli_fetch_array($qry1)){ 
								echo "<li><a href='place.php?p_id=$row2[0]'>$row2[nama_properti]</a>";
									echo "
										<a href='edit.php?id=$row2[id_properti]'>
											<i><img src='img/edit.png' style='width: 15px;' class='glyphicon glyphicon-trash pull-right'></i> 
										</a>";?>
										<a onclick="return confirm('are you sure to delete?')" href="delete.php?id=<?php echo $row2['id_properti'];?>">
											<i><img src="img/delete.png" style="width: 15px; " class='glyphicon glyphicon-trash pull-right'></i>
										</a>
							<?php	}
								echo "</li>";
							 ?>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading turqoise">Uncategorized </div>
						<div class="panel-body">
							<img class="cat-img" src="img/uncategorized1.jpg"/>
							<br><br>
							<ul>
							<?php 
							$qry1 = mysqli_query($con, "
								SELECT * FROM properti LEFT JOIN kategori
								ON properti.id_kategori = kategori.id_kategori
								WHERE kategori.id_kategori IS NULL
								");
								while($row2= mysqli_fetch_array($qry1)){ 
								echo "<li><a href='place.php?p_id=$row2[0]'>$row2[nama_properti]</a>";
									echo "
										<a href='edit.php?id=$row2[id_properti]'>
											<i><img src='img/edit.png' style='width: 15px;' class='glyphicon glyphicon-trash pull-right'></i> 
										</a>";?>
										<a onclick="return confirm('are you sure to delete?')" href="delete.php?id=<?php echo $row2['id_properti'];?>">
											<i><img src="img/delete.png" style="width: 15px; " class='glyphicon glyphicon-trash pull-right'></i>
										</a>
							<?php	}
								echo "</li>";
							 ?>
							</ul>
						</div>
					</div>
				</div>	

			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>