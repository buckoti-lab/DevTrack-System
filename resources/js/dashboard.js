$.ajaxSetup({
  headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
})    

/*-- SweetAlert imports ---*/
import Swal from "sweetalert2";
window.Swal = Swal;

$(document).ready(function(e){
       $("#lower-content").load("home", function(response, status, xhr) {
           if (status === "error") {
              $("#lower-content").html("<p>Error loading dashboard content.</p>");
            }
        });

        $("#toggle-navbar-btn").click(function(e){
            $("#side-navbar").toggleClass("side-navbar-collapsed");
        });

        $("#upper-nav a,#upper-profile-content a").click(function (e) {
        e.preventDefault(); 
        let pageName = $(this).data("content");
        if(pageName){
          let url = pageName;
          $("#lower-content").load(url, function(response, status, xhr) {
             if (status === "error") {
             $("#lower-content").html("<p>Error loading content from: " + url + "and" +xhr.responseText+".</p>");
            }
          });
        }else{
            $(".side-submenu").not($(this).next()).slideUp();
            $(this).next(".side-submenu").slideToggle();
        }
     });

    $("#upper-content-profile").on("click", function(e){
      $("#profile-content").slideToggle();
     })
      
    $(window).on("click",function(e){
        if (!$(e.target).closest("#profile-content").length &&
        !$(e.target).closest("#upper-content-profile").length) {
            $("#profile-content").slideUp();
        }
    });

     

     $.ajax({
     url: '/dashboard_api',  
     type: 'POST',
     dataType: 'json',
     success: function(response) {
     if (response.success) {
      const profileImage = response.image; 
      $('#profile-img').attr('src', profileImage);
     } else {
      alert("Failed to load data"+response.message);
    }
    },
    error: function(xhr,status,error) {
    alert("Failed to fetch user data."+xhr.responseText);
  }
 });

})

