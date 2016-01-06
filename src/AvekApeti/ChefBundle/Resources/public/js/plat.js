
$(document).ready(function()
{
    console.log($("#tableau-plats"));
    $("#tableau-plats").on("click",".delete",function(event)
    {
        event.preventDefault();
        if(confirm("Etes-vous sur de vouloir supprimer ce plat ?")) {
            var aDelete = $(this);
            var urlDelete = aDelete.attr("href");
            $.ajax({
                    type: "GET",
                    url: urlDelete
                })
                .done(function()
                {
                    aDelete.closest("tr").fadeOut(600,function()
                    {
                        $(this).remove();
                    });
                });
        }
    })
})