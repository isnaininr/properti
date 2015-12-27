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
	$id = $_GET['id'];
	
	if( isset( $_POST['edit'] ) ):
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		$kategori = $_POST['kategori'];
		$locLat = $_POST['locLat'];
		$locLng = $_POST['locLng'];

		mysqli_query($con,
			"UPDATE properti SET
			nama_properti = '$nama' ,
			lokasi = GEOMFROMTEXT(  'POINT($locLat $locLng)', 0 ),
			alamat = '$alamat',
			id_kategori = '$kategori'
			WHERE
			id_properti = '$id'
		;")
		or die(mysql_error());
		echo "Your data has been Updated.";	
		endif;
?>
<br><br><br>
	<div class="section">
		<div class="wrapper">
			<div class="panel panel-default">
			  <div class="panel-heading turqoise places">Edit Properti</div>
			  <div class="panel-body">
			  <?php
				$result = mysqli_query($con, "SELECT * FROM properti WHERE id_properti='$id'");
				$data = mysqli_fetch_object( $result );
			  ?>
			  <form action="" method="POST">
					  <div class="form-group">
					    <input type="text" name="nama" value="<?php echo $data->nama_properti ?>" class="form-control as1" placeholder="Nama Properti">
					  </div>
					  <div class="form-group">
					    <input type="text" name="alamat" value="<?php echo $data->alamat ?>" class="form-control" placeholder="Alamat">
					  </div>
					  <div class="form-group">
							<?php
							mysql_connect("localhost", "root","") or die(mysql_error());
							mysql_select_db("basisdata") or die(mysql_error());
							$query = "SELECT * FROM kategori";
							$result = mysql_query($query) or die(mysql_error()."[".$query."]");?>
							
							<select name="kategori" class="form-control">
							<?php 
							$sql = mysql_query("SELECT * FROM kategori, properti where kategori.id_kategori = properti.id_kategori and id_properti = '$id'");
							$hasil = mysql_fetch_array($sql) or die(mysql_error()."[".$sql."]");
							
							if($hasil['nama_kategori'] != ''){
								$val = $hasil['nama_kategori'];
								echo "<option value='$val;'>
								  $hasil[nama_kategori]
								</option>";
							
							}
							while($row = mysql_fetch_array($result)){
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
					    <input type="Submit" class="btn btn-success " value="Update" name="edit" >
						<a href="./index.php"> <button type="button" class="btn btn-defaut"> Back </button></a>
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