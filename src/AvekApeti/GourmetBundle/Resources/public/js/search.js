function initMap()
{
  
  var options = {
    componentRestrictions: {country: 'fr'}
  };
  var input = document.getElementById('adressInput');
  var autocomplete = new google.maps.places.Autocomplete(input, options);


  var geocoder = new google.maps.Geocoder();

  //setPositionFromAddress('75017 Paris, France');

  function setPositionFromAddress(address)
  {
    if(address==''){
      address='Paris, France';
    }
    geocoder.geocode( { 'address': address}, function(results, status)
    {
      if (status == google.maps.GeocoderStatus.OK)
      {
        center = results[0].geometry.location;
        console.log(center);
        // TODO
        console.log(center.lat());
        console.log(center.lng());
        //map.setCenter(center);
        //search();
      }
    });
  }


}