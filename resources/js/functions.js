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


function viewDemo(demoId){

    $.get('/demo/view/'+demoId,function(response){

        const filePath = response.file.file_path;

        if(filePath.endsWith("mp4")){
            $("#viewDemoContent").html(`<video  controls>
                                            <source src="${filePath}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>`);
        }else{
            $("#viewDemoContent").html(`<img src="${filePath}"></img>`);
        }
        
         $("#viewDemoModal").modal("show")
    })
}

function editDemo(demoId){
    $.get("/demo/view/"+demoId, function(response){
        
        const demo = response.file;

        $("#edit_demo_id").val(demo.id);
        $("#edit_demo_description").val(demo.description);
        $("#edit_demo_file").val(demo.file);

        $("#editDemoModal").modal("show");
    })

}

