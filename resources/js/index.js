/*==========Index page scripts=========*/
$(document).ready(function(e){
    $("#index-content").load("home", function(response, status, xhr) {
        if (status === "error") {
           $("#index-content").html("<p>Error loading home content.</p>");
        }
    });

    $(".index-dynamic-page").click(function (e) {
      e.preventDefault(); 
      let pageName = $(this).data("content");
      let url = pageName;
      $("#index-content").load(url, function(response, status, xhr) {
          if (status === "error") {
            $("#index-content").html("<p>Error loading content from: " + url + ".</p>");
          }
       });
    });

    $('#hamburger').click(function () {
        $('#navbar ul').toggleClass('show');
    });
});