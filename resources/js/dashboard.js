$.ajaxSetup({
  headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
})    

/*=======Dashboard scripts=======*/
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

    $("#upper-content-profile").click(function(e){
      $("#profile-content").slideToggle();
     })
      
    $(window).click(function (e) {
      if ($(e.target).is("#profile-content")) $("#profile-content").slideUp();
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
      //window.location.href = 'index';
      alert("Failed to load data"+response.message);
    }
    },
    error: function(xhr,status,error) {
    alert("Failed to fetch user data."+xhr.responseText);
  }
 });

})
