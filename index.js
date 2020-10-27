function closeNav() {
  document.getElementById("Sidenav").style.width = "0%";
}

function openNav() {
  document.getElementById("Sidenav").style.width = "50%";
}


function updateModalContent()
{
    $( "#modalContent" ).load(window.location.href + "#modalContent" );
}

$( document ).ready(function() {
  if ($(this).width() <  768) {
    $("#diamond-carousel").removeClass('h-100').addClass('h-50').addClass('my-5')
    $("#first-carousel").removeClass('h-50').addClass('h-25')
    $("#second-carousel").removeClass('h-50').addClass('h-25')
    $(".car-img").removeClass('h-50').addClass('h-75')
  } else {
    $("#diamond-carousel").removeClass('h-50').addClass('h-100')
    $("#first-carousel").removeClass('h-25').addClass('h-50')
    $("#second-carousel").removeClass('h-25').addClass('h-50')
    $(".car-img").removeClass('h-75').addClass('h-50')
  }
});

$(window).bind("resize", function () {
  if ($(this).width() <  768) {
    $("#diamond-carousel").removeClass('h-75').addClass('h-50')
    $("#first-carousel").removeClass('h-50').addClass('h-25')
    $("#second-carousel").removeClass('h-50').addClass('h-25')
    $(".car-img").removeClass('h-50').addClass('h-75')

  } else {

    $("#diamond-carousel").removeClass('h-50').addClass('h-75')
    $("#first-carousel").removeClass('h-25').addClass('h-50')
    $("#second-carousel").removeClass('h-25').addClass('h-50')
    $(".car-img").removeClass('h-75').addClass('h-50')
  }
});


$(document).ready(function(){


  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();

    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });


});
