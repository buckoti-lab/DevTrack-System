$.ajaxSetup({
  headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
})    

// ========= Importing sweetalert2 ===========
import Swal from "sweetalert2";
window.Swal = Swal;

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


function editUser(user){
    $("#edit_first_name").val(user.first_name);
    $("#edit_second_name").val(user.second_name);
    $("#edit_last_name").val(user.last_name);
    $("#edit_email").val(user.email);
    $("#edit_phone").val(user.phone ?? '');
    $("#edit_sex").val(user.sex);
    $("#edit_role").val(user.role);

    $("#editForm").data('userId', user.id);
    $("#editModal").fadeIn();
}


// ===== DELETE USER =====
function deleteUser(userId){
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if(result.isConfirmed){
            $.ajax({
                url: "/users/delete/" + userId,
                type: "DELETE",
                data: {_token: '{{ csrf_token() }}'},
                success: function(response){
                    if(response.success){
                        Swal.fire("Success", response.message, "success").then(() => $('a[data-content="users"]').trigger('click'));
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function(xhr){
                    Swal.fire("Error", "Failed to delete user: " + xhr.responseText, "error");
                }
            });
        }
    });
}


