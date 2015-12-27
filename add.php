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
	include('navbar.php');
	
	if( isset( $_POST['add'] ) ):
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		$kategori = $_POST['kategori'];
		$locLat = $_POST['locLat'];
		$locLng = $_POST['locLng'];

		mysqli_query($con,
			"INSERT INTO  properti (
			id_properti ,
			nama_properti ,
			lokasi ,
			alamat ,
			id_kategori
			)
			VALUES (
			NULL,  '$nama',  GEOMFROMTEXT(  'POINT($locLat $locLng)', 0 ), '$alamat', '$kategori'
			)
		;")
		or die(mysql_error());
		echo "Your data has been saved.";	
		endif;
?>
<br><br><br>
	<div class="section">
		<div class="wrapper">
			<div class="panel panel-default">
			  <div class="panel-heading turqoise places">Tambah Properti</div>
			  <div class="panel-body">
			  <form action="" method="POST">
					  <div class="form-group">
					    <input type="text" name="nama" class="form-control as1" placeholder="Nama Properti">
					  </div>
					  <div class="form-group">
					    <input type="text" name="alamat" class="form-control" placeholder="Alamat">
					  </div>
					  <div class="form-group">
							<?php
							mysql_connect("localhost", "root","") or die(mysql_error());
							mysql_select_db("basisdata") or die(mysql_error());
							$query = "SELECT * FROM kategori";
							$result = mysql_query($query);?>
							
							<select name="kategori" class="form-control">
							<?php while($row = mysql_fetch_array($result)){
							   echo "<option value='$row[id_kategori];'>
								  $row[nama_kategori]
								</option>";
							}
							?>      
							</select>
					  </div>
					  
				<div class="row">
			  		<div class="col-md-6">
						<div class="form-group">
						  <label>Latitude</label>
						  <input type="text" class="form-control data-lat"  name="locLat" value="-7.7833" placeholder="Latitude">
						</div>    
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Logitude</label>
						  <input type="text" name="locLng" class="form-control data-lng"  value="110.3667" placeholder="Logitude">
						</div>    
					</div>
				</div>
				<div class="row">
			  		<div class="col-md-12">
						<div id="map"></div>    
					</div>
				</div>
				<br>
					  <div class="form-group">
					    <input type="Submit" class="btn btn-success " value="Add" name="add" >
					  </div>
				  </div>
		      </form>
			</div>  
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<script>
         CKEDITOR.replace( 'editor1' );
    </script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
	
     dataLat = parseFloat($('.data-lat').attr('value'));
      dataLng = parseFloat($('.data-lng').attr('value'));
      var myLatLng = {lat: dataLat, lng: dataLng};
      var map;
      var refMarker;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:dataLat,  lng:dataLng},
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var drag;
       

      

		  addMarker(myLatLng, map);
		    	  
		  	$('.data-lat').on("change", function () {
  				//alert($(this).val());
  				deleteMarkers();
  			    map.setCenter(new google.maps.LatLng(parseFloat($(this).val()), dataLng));
  			    addMarker(new google.maps.LatLng(parseFloat($(this).val()), dataLng),map);
	  		    //marker.setPosition(new google.maps.LatLng(parseFloat($(this).val()), dataLng));
				  		
			});
		  	$('.data-lng').on("change", function () {
  				//alert($(this).val());
  				deleteMarkers();
  				map.setCenter(new google.maps.LatLng(dataLat, parseFloat($(this).val())));
  				//marker.setPosition(new google.maps.LatLng(dataLat, parseFloat($(this).val())));
		
			});
		  
      }
function addMarker(latlng,map) {
    var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'hello',
            draggable:true
    });
    refMarker = marker;
    google.maps.event.addListener(refMarker, 'dragend', function (event) {
			   $('.data-lat').attr('value', this.getPosition().lat());
			   $('.data-lng').attr('value', this.getPosition().lng());
			    
			});		  
}
function deleteMarkers() {
  refMarker.setMap(null);
  refMarker=null;
}
	</script>
	<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8V020aIxzsnq7PlhFS0a0z50wgIgW7rM&callback=initMap">
    </script>
</body>
</html>