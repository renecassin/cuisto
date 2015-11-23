function handleHeaderOpacity() {
    $('.header-opacity').css('height', $('header').css('height'));
}

$(document).ready(function(){
    handleHeaderOpacity();
    $(window).resize(function(){
        handleHeaderOpacity();
    });
});

