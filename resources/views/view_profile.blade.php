<div class="container">
    <h3>My profile</h3>
    <div id="my-profile">
        <img id="ViewProfile-picture"  alt="Profile Picture" title="User profile picture">
    </div>
    <table>
        <tbody>
            <tr>
              <td style="padding: 8px; font-weight: bold;">First name</td>
              <td style="padding: 8px;" id="ViewFname">{{ Auth::user()->first_name}}</td>
            </tr>
            <tr>
              <td style="padding: 8px; font-weight: bold;">Middle name</td>
              <td style="padding: 8px;" id="ViewMname">{{ Auth::user()->second_name}}</td>
            </tr>
            <tr>
              <td style="padding: 8px; font-weight: bold;">Last name</td>
              <td style="padding: 8px;" id="ViewLname">{{ Auth::user()->last_name}}</td>
            </tr>
            <tr>
              <td style="padding: 8px; font-weight: bold;">Email</td>
              <td style="padding: 8px;" id="ViewEmail">{{ Auth::user()->email}}</td>
            </tr>
            <tr>
              <td style="padding: 8px; font-weight: bold;">Phone</td>
              <td style="padding: 8px;" id="ViewPhone">{{ Auth::user()->phone}}</td>
            </tr>
            <tr>
              <td style="padding: 8px; font-weight: bold;">Sex</td>
              <td style="padding: 8px;" id="ViewSex">{{ Auth::user()->sex}}</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(e){

        $.ajax({
            url:'dashboard_api',
            type:'POST',
            dataType:'json',
            processData:false,
            success:function(response){
             if(response.success){
                const profileImage = response.image; 
                $('#ViewProfile-picture').attr('src', profileImage);
             }else{
                swal.fire({
                  icon:"error",
                  title:"Error!",
                  text:response.message,
                  confirmButtonText:"OK"
                })
             }
            },
            error:function(xhr,status,error){
               Swal.fire({
               icon: 'error',
               title: 'Error!',
               text: 'Could not load user profile.'+error
               });
            }
        });
    });
</script>