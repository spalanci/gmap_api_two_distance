<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-9">
  <title>iki durak arası mesafe</title>
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.9.1.js'></script>
<script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key=<key>">
</script>
<script type='text/javascript' src="https://rawgithub.com/HPNeo/gmaps/master/gmaps.js"></script>  
  <style type='text/css'>
     #map {
     height: 500px;
     width: 500px;
 }
  </style> 
<script type='text/javascript'> 

$(function init(){
jQuery(document).ready(function () {
    var map;
    var latlng1;
    var latlng2;

    GMaps.geocode({
        address: $('#Start').val(),
        callback: function (results, status) {
            if (status == 'OK') {
                latlng1 = results[0].geometry.location;
                GMaps.geocode({
                    address: $('#End').val(),
                    callback: function (results, status) {
                        if (status == 'OK') {
                            latlng2 = results[0].geometry.location;

							<?php 
			//list = lat#long
								$x1  = $list["x"];
								$xy1 = explode("#",$x1);
								$x2  = $list["y"];
								$xy2 = explode("#",$x2);
							?>
                            map = new GMaps({
                                div: '#map',
                                lat: "<?php echo $xy1[0];?>",//latlng1.lat(),
                                lng: "<?php echo $xy1[1];?>",//latlng1.lng(),
                                zoom: 12
                            });
                            map.drawRoute({

                                //origin: [latlng1.lat(), latlng1.lng()],
                                //destination: [latlng2.lat(), latlng2.lng()],
                                origin: [<?php echo $xy1[0];?>, <?php echo $xy1[1];?>],
                                destination: [<?php echo $xy2[0];?>, <?php echo $xy2[1];?>],
                                travelMode: 'driving',
                                strokeColor: '#131540',
                                strokeOpacity: 0.6,
                                strokeWeight: 6
                            });
                            map.getRoutes({
                                origin: [<?php echo $xy1[0];?>, <?php echo $xy1[1];?>],
                                destination: [<?php echo $xy2[0];?>, <?php echo $xy2[1];?>],
                                callback: function (e) {
                                    var time = 0;
                                    var distance = 0;
					 var query = '';
                                    for (var i=0; i<e[0].legs.length; i++) {
                                        time += e[0].legs[i].duration.value;
                                        distance += e[0].legs[i].distance.value;
                                    }
                                    $('p#Time').text(time+' Seconds');
                                    $('p#Distance').text(distance+' Meters');
					 query = 'insert into nmesafe='+distance+', nsure='+time+' where sdurakkodu1=\'<?php echo $list[2];?>\' and sdurakkodu2=\'<?php echo $list[3];?>\';';
                                    $('p#query').text(query);
									
					window.location.href='?<?php echo "i=$i&";?>query=' + query;
                                }
                            });
                        }
                    }
                });
            }
        }
    });
});
});

</script>
<?php 

		 $baslangic = (isset($_POST['Start'])) ? $_POST['Start'] : "taksim,istanbul";	
		 $varis 	= (isset($_POST['End'])) ? $_POST['End'] : "eminönü,istanbul";	
?>

</head>
<body onload="init()">
<form action="#" method="post">
Başlangıç : 
<input type="text" id="Start" name="Start" value="<?php echo $xy1[0];?>, <?php echo $xy1[1];?>" />
<br />Hedef :
<input type="text" id="End" name="End" value="<?php echo $xy2[0];?>, <?php echo $xy2[1];?>" />
<input type="submit" id="send" value=" Bul " />
</form>
<br />
<div id="map"></div>
<p id="Time" />
<p id="Distance" />
<p id="query" />
</body>
</html>