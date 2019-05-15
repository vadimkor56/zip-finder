<?php

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>ZipFinder</title>
    
    <style>
    
      #result {
        display: none;
      }
      
      #map {
        height: 300px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
  </head>
  <body>
    <div class="container text-center mt-4">
      <h1>Postcode Finder</h1>
      <p>Enter a partial address to get the postcode.</p>
      
      <div>
        <div class="form-group">
          <input type="text" class="form-control" id="address" aria-describedby="emailHelp" placeholder="Enter address">
        </div>
        
        <button id="find" class="btn btn-primary">Find</button>
      </div>
      
      <div id="result">
        <hr class="mt-3">
        <div id="resultZip" class="alert alert-success" role="alert">
        </div>
        <div id="map"></div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbMhIJ6jc7eZqnVNyFpQFtDtIC63LD0hE&callback=initMap">
    </script>
    
    <script>
      function initMap(la, ln) {
        // The location of Uluru
        var uluru = {lat: la, lng: ln};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 15, center: uluru});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
      }
      $("#find").click(function() {
        if ($("#address").val() != "") {
          $("#result").show();
          $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json?address="+ encodeURIComponent($("#address").val()) + "&key=AIzaSyC8J08MxJRX2CNQpPm_kwqjWNhCHfQo8Nk",
            type: "GET",
            success: function(data) {

              if (data['status'] != 'OK') {
                $("#resultZip").html("Couldn't find. Sorry!");
              } else {
                $.each(data['results']['0']['address_components'], function(key, val) {
                  if (val['types'][0] == "postal_code") {
                    if (!isNaN(val['long_name'])) {
                      	$("#resultZip").html("Couldn't find. Sorry!");
                    } else {
                    	$("#resultZip").html(val['long_name']); 
                    }
                  }
                });  
                
                let la = data['results']['0']['geometry']['location']['lat'];
                let ln = data['results']['0']['geometry']['location']['lng'];
                
                initMap(la, ln);
              }

            }
          });  
        }
        
      });
      
    
    </script>
  </body>
</html>