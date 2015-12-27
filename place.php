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
	if(isset($_GET['p_id'])) {
		$id = $_GET['p_id'];
	} 
	else {
		$id = '';
	}
	$qry = "select *, (X(lokasi)) as lat, (Y(lokasi)) as lng 
	FROM properti
	WHERE properti.id_properti = $id";
	
	if(mysqli_query($con, $qry)){
		$row = mysqli_fetch_array(mysqli_query($con,$qry ));
		
	include('navbar.php');
?>
	<input type="hidden" value="<?php echo $row['lat']; ?>" class="data-lat">
	<input type="hidden" value="<?php echo $row['lng']; ?>" class="data-lng">
	<input type="hidden" value="<?php if(isset($_GET['edit'])) echo 1; else echo 0; ?>" class="isEdit">
	<div class="section">
		<div class="wrapper">
			<div class="panel panel-default">
			  <div class="panel-heading turqoise judul"><?php echo $row['nama_properti'];?></div>
			  <div class="panel-body">
			  <div class="">
			  	<div class="row">

			  		<div class="col-md-12">
							<br>
			  				<div class="content">
			  					<div class="title"><?php echo $row['nama_properti'] ?></div>
			  					<div class="sub"><small> <?php echo $row['alamat'] ?></small></div>
			  				</div>

			  			<?php
			  				if(isset($_GET['edit']) ){
			  			 ?>
			  			<div class="row">
				  			<div class="col-md-3 col-md-offset-4">
					  			<div class="alert alert-info">
					  			<h3>Edit Box</h3>
									<div class="input-group">
									  <input type="text" class="form-control" id="aa1"  readonly placeholder="Recipient's username" >
									</div><br>
									<div class="input-group">
									  <input type="text" class="form-control" id="aa2"  readonly placeholder="Recipient's username" >
									</div>
					  			</div>	
					  		</div>	
			  			</div>
			  			<?php } ?>
			  			
			  			<h3>Peta Lokasi</h3>
			  			<div id="map">
			  				
			  			</div>

			  		</div>	  	
			  	</div>
			  </div>
			</div>  
			</div>		
		</div>
	</div>
<?php }
	else {
		echo $_GET['p_id'];
	}

?>		
	
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
     dataLat = parseFloat($('.data-lat').attr('value'));
      dataLng = parseFloat($('.data-lng').attr('value'));
      var myLatLng = {lat: dataLat, lng: dataLng};
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:dataLat,  lng:dataLng},
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var drag;
       
        if($('.isEdit').attr('value')=='0') { drag = false;} else {drag = true;}
      
		  var marker = new google.maps.Marker({
		    position: myLatLng,
		    map: map,
		    title: 'Hello World!',
		    draggable: drag
		  });
		  var contentString = 'Lat : ' + marker.getPosition() ;		  
		  
		    
			google.maps.event.addListener(marker, 'dragend', function (event) {
			    document.getElementById("aa1").value = this.getPosition().lat();
			    document.getElementById("aa2").value = this.getPosition().lng();
			});		   

		  google.maps.event.addListener(marker, 'click', function() {
		 	var infowindow = new google.maps.InfoWindow({
		    	content: '<a href="edit.php?id=2" class="btn btn-info">Edit</a>'
		  	});	 	
		    infowindow.open(map, this);
		  });		  
      }
      
    </script>
	<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8V020aIxzsnq7PlhFS0a0z50wgIgW7rM&callback=initMap">
    </script>
</body>
</html>