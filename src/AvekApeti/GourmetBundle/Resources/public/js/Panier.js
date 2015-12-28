
function affichagePanier(){
    $.get( "widget", function(data) {
        $("#widgetPanier").html(data);
    });
}

//Il faudra ajouter une balise data et y placer l'id
$('.ajout_plat_panier').click(function(event){
    event.preventDefault();
    event.stopImmediatePropagation();
    var id= $(this).data().id;
    ajoutPlat(id);

});
$('.ajout_menu_panier').click(function(event){
    event.preventDefault();
    event.stopImmediatePropagation();
    var id= $(this).data().id;
    ajoutMenu(id);

});
$('.suppr_menu_panier').click(function(event){
    event.preventDefault();
    event.stopImmediatePropagation();
    var id= $(this).data().id;
    supprMenu(id);

});
$('.suppr_plat_panier').click(function(event){
    event.preventDefault();
    event.stopImmediatePropagation();
    var id= $(this).data().id;
    supprPlat(id);

});
$('.reset_panier').click(function(event){
    event.preventDefault();
    event.stopImmediatePropagation();
    $.get( "reset", function() {
        affichagePanier();
    });
});

function ajoutPlat(Id){
    $.get( "ajout/plat/"+Id, function() {
    }) .done(function() {
        //alert( "second success" );
    })
        .fail(function() {
            //      alert( "error" );
        })
        .always(function() {
            //      alert( "finished" );
            affichagePanier();
        });

}

function ajoutMenu(Id){
    $.get( "ajout/menu/"+Id, function() {
    }) .done(function() {
        //     alert( "second success" );
    })
        .fail(function() {
            //        alert( "error" );
        })
        .always(function() {
            affichagePanier();
        });

}

function supprMenu(Id){
    $.get( "suppr/menu/"+Id, function() {
    }) .done(function() {
        //    alert( "second success" );
    })
        .fail(function() {
            //        alert( "error" );
        })
        .always(function() {
            affichagePanier();
        });

}

function supprPlat(Id){
    $.get( "suppr/plat/"+Id, function() {
    }) .done(function() {
        //     alert( "second success" );
    })
        .fail(function() {
            //       alert( "error" );
        })
        .always(function() {
            affichagePanier();
        });

}

