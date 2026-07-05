<div class="container">
    <h3>Reset user password to user's surname.</h3>
        <form id="ResetPasswordForm">
        @csrf
           <input type="email" name="email" id="email" placeholder="User's email" class="form-control mb-2">
           <span id="username_error" class="error"></span>
           <input type="submit" value="Update Password">
       </form>
</div>
<script>
    $(document).ready(function(e){
        $("#ResetPasswordForm").on("submit",function(e){
            e.preventDefault();

            const valid = true;
            
            const formData = new FormData(this);

            $.ajax({
               url:"{{ route('password.update') }}",
               type:"POST",
               data:formData,
               processData:false,
               contentType:false,
               success: function(response){
                if(response.success){
                Swal.fire("Success!", response.message, "success").then(() => $('a[data-content="reset_user_password"]').trigger('click'));
                }else{
                    Swal.fire({
                        title:"Error!",
                        text:response.message,
                        icon:"error",
                        confirmButtonText:"OK"
                    });
                }
               },
               error: function(xhr,status,error){
                Swal.fire({
                    title:"Error!",
                    text:'Something went wrong.'+error+":::"+xhr.responseText,
                    icon:"error",
                    confirmButtonText:"Try again"
                });
               }
            })
        })
    })
</script>