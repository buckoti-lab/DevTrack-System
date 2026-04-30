<div class="container">
    <h3>Change password</h3>

    <!-- <form id="changePasswordForm" style="width:400px;"> -->
    <form id="changePasswordForm">
        <input type="password" name="old_password" id="old_password" class="form-control mb-2" placeholder="Old Password" >
        <input type="password" name="new_password" id="new_password" class="form-control mb-2" placeholder="New Password" >
        <span id="new_password_error" class="error"></span>
        <input type="password" name="repeated_password" id="repeated_password" class="form-control mb-2" placeholder="Repeat Password" >
         <span id="repeated_password_error" class="error"></span>
        <input type="submit" value="Update Password">
    </form>
</div>
    
<script>
  $(document).ready(function () {
      
     $("#changePasswordForm").on("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      $("#new_password_error").text("");
      $("#repeated_password_error").text("");

      let valid = true;
      let anyEmpty = false;

      const new_password = $("#new_password").val().trim();
      const repeated_password = $("#repeated_password").val().trim();
      const old_password = $("#old_password").val().trim();

      const passwordPattern = /^(?=(.*[a-z]){2,})(?=(.*[A-Z]))(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
      

     
    if(new_password === "" || repeated_password=== "" || old_password===""){
      swal.fire({
        title:"Error",
        text:"All fields are required!",
        icon:"error",
        confirmButtonText:"OK",
      });
      valid=false;
      anyEmpty = true;
    }
     
    if(!anyEmpty){
     if(!passwordPattern.test(new_password)){
        $("#new_password_error").text("Password must contain at least two lowercase letters, one uppercase letter, one special character, and be at least 8 characters long.").css("color","red");
        valid = false;
      }
     if(repeated_password !== new_password){
        $("#repeated_password_error").text("Passwords do not match!.").css("color","red");
        valid = false;
      }
    }

     
      if(valid){
        $.ajax({
        url: 'change_password_api',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if(response.success){
             swal.fire("Success!",response.message,"success").then(() => window.location.href = "{{ route('logout') }}");
          }else{
            Swal.fire({
            title: 'Error!',
            text: response.message,
            icon: 'error',
            confirmButtonText: 'OK'
          });           
          }
        },
        error: function (xhr) {
          Swal.fire({
            title: 'Error!',
            text:  "Failed to update password"+xhr.responseText,
            icon: 'error',
            confirmButtonText: 'Try Again'
          });
        }
      });
      }
    });
  });
</script>

