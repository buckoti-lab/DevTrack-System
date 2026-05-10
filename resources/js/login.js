$(document).ready(function(e){
       /*========Login page scripts=====*/
    $("#loginForm").on("submit",function(e){
    e.preventDefault();
    
    const formData = new FormData(this);

    $.ajax({
    // url: `{{ route('post.login') }}`,
    url: `login`,
    method: 'POST',
    data: formData,
    processData:false,
    contentType:false,
    success: function(response) {
      if (response.success) {
          if(response.role === "admin"){
              window.location.href="dashboard";        
          }else{
              window.location.href="client_dashboard";
          }
      } else {
          Swal.fire({
            title: 'Error!',
            text: response.message,
            icon: 'error',
            confirmButtonText: 'Try Again'
          });
      }
     },
      error: function (xhr,status,error) {
          Swal.fire({
            title: 'Error!',
            text: 'Something went wrong.'+error,
            icon: 'error',
            confirmButtonText: 'Try Again'
          });
          alert("Something went wrong."+error);
    }
  });
 });

});