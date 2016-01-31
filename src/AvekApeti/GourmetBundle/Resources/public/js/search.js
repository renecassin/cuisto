function initMap()
{
  var $geolocPlat = $('.geoloc');
  var options = {
    componentRestrictions: {country: 'fr'}
  };
  var input = document.getElementById('adressInput');
  var autocomplete = new google.maps.places.Autocomplete(input, options);
  var geocoder = new google.maps.Geocoder();

  var map = document.getElementById('map');
  if (map)
  {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.856614, lng: 2.3522219},
        zoom: 13
      });

      if (input.value) {
        setPositionFromAddress(input.value);
      }
  }

  google.maps.event.addListener(map, "dragend", function() {
    //center = map.getCenter();
    //actual_page = 1;
    //search();
    // TODO: Reload result search when user "drag" the map
  });

  
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
        map.setCenter(center);
        /*
        // positioner the user on the map
        var marker = new google.maps.Marker({
          position: {lat: center.lat(), lng: center.lng()},
          map: map,
        });
        */
        $geolocPlat.each(function(){
          
          var that = $(this);
          new google.maps.Marker({
            position: {lat: parseFloat(that.attr('data-lat')), lng: parseFloat(that.attr('data-lng'))},
            map: map
          });

        });

      }
    });
  }



  // Add all plat on the map
  // var box = getCuisinierBox(actual,data.user_id,data.is_gourmet);
  // var item = '<li>'+box+'</li>';
  // $list.append(item);
  // var actual_marker = addMarker(new google.maps.LatLng(actual.latitude, actual.longitude),{
  //   icon: "/images/cheff_list.png",
  //   title: actual.name
  // },box,actual.id);


  // Create html one plat
  // function getCuisinierBox(cuisinier,user_id,is_gourmet){
  //   var short_name = cuisinier.name.length>15?cuisinier.name.substring(0,15)+'...':cuisinier.name;
  //   var html='<div class="cuisinier-box" data-cuisinier-id="'+cuisinier.id+'">';
  //   html+=       '<div class="image-container">';
  //   html +=          '<a href="'+cuisinier.url+'" class="img2bg" target="_blank">';
  //   html +=          (cuisinier.profile_image?'<img src="/uploads/images/'+cuisinier.profile_image+'" alt="">':'<img src="/images/notfound.jpg" alt="">');
  //   html +=          '</a>';
  //   if(user_id!=0 && user_id!=cuisinier.id){
  //     html +=          '<div class="icon icon-favorite'+(cuisinier.favorite==1?' selected': '')+'" data-favorite-url="'+cuisinier.favorite_url+'" title="'+(cuisinier.favorite==1?'Retirer des favoris': 'Ajouter aux favoris')+'"></div>';
  //   }
  //   html +=          '<div class="price-container">Prix moyen : <span class="price">'+parseFloat(cuisinier.avg_price>0?cuisinier.avg_price:cuisinier.price).toFixed(2)+' €</span></div>';
  //   html +=      '</div>';
  //   html +=      '<div class="name"><strong><a target="_blank" href="'+cuisinier.url+'" title="'+cuisinier.name+'">'+short_name+'</a></strong></div>';
  //     // html +=      '<div class="rating-block comuneat">';
  //     // html +=          '<div class="label text-secondary">Note Comuneat</div>';
  //     // html +=          '<div class="rating">';
  //     // html +=              '<div class="stars-container"><div class="score" style="width:'+(cuisinier.comuneat_score*100/5)+'%"></div></div>';
  //     // html +=          '</div>';
  //     // html +=      '</div>';
  //     html +=      '<div class="rating-block users">';
  //     // html +=          '<div class="label text-primary">Note des internautes</a></div>';
  //     html +=          '<div class="rating">';
  //     html +=              '<div class="stars-container"><div class="score" style="width:'+(cuisinier.score*100/5)+'%"></div></div>';
  //     html +=          '</div>';
  //     html +=      '</div>';
  //     html +=      '<div>Code postal : <strong>'+cuisinier.postal_code+'</strong></div>';
  //     html +=      '<div>Ville : <strong>'+cuisinier.city+'</strong></div>';
  //     if(cuisinier.food_types.length>0){
  //       html+=      '<div>Cuisine ';
  //       for(var ftk in cuisinier.food_types){
  //         if(ftk<2){
  //           html+=cuisinier.food_types[ftk]+(cuisinier.food_types.length>(ftk+1)?', ':'');
  //         }else{
  //           html+=      ' ...(+'+(cuisinier.food_types.length-2)+')';
  //           break;
  //         }
  //       }
  //       html+=          '</div>';
  //     }
  //     html +='</div>';
  //     return html;
  // }

}