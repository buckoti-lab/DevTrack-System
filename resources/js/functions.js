function deleteUser(userId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: "/users/" + userId,  
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
              },
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="users"]').trigger('click'));
              }else{
                swal.fire({
                    title:"Error",
                    text: response.message,
                    icon:"error",
                    confirmButtonText:'OK'   
                });                
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error','Failed to delete user: ' +  xhr.responseText, 'error')
           }
        });
        }
      });
}


// ===== OPEN EDIT MODAL FUNCTION =====
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


function deleteResource(res_id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'resources_api?action=delete',
            type: 'POST',
            data: { res_id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Sccess",response.message,"success").then(() => $('a[data-content="view_resources"]').trigger('click'));
              }else{
                swal.fire({
                    title:"Error",
                    text: response.message,
                    icon:"error",
                    confirmButtonText:'OK'   
                });                
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error','Failed to delete resource: ' + xhr.responseText, 'error')
           }
        });
        }
      });
}


function downloadResource(res_id) {
    const url = 'resources_api?id=' + encodeURIComponent(res_id);
    window.location.href = url;
}

function deleteAnnouncement (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'announcements_api?action=delete',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="announcements"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete Announcement: ' + error, 'error')
              Swal.fire("Error",xhr.responseText,'error');
            }
          });
        }
      });
}

function editAnnouncement(an_id,content,target,valid_until){
  $('#editFormid').val(an_id);
  $('#editFormcontent').val(content);
  $('#editFormtarget').val(target);
  $('#editFormvalid_until').val(valid_until);
  $('#editModal').show();
}



function deleteCourse(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'courses_api?action=delete',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="courses"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error', 'Failed to delete course: ' + error, 'error')
            }
          });
        }
      });
}

function editCourse(course_id,code,name,description,duration,fee,type,exit_level,facility_status){
  $('#editFormid').val(course_id);
  $('#editFormcode').val(code);
  $('#editFormname').val(name);
  $('#editFormdescription').val(description);
  $('#editFormduration').val(duration);
  $('#editFormtype').val(type);
  $('#editFormfee').val(fee);
  $('#editFormexitlevel').val(exit_level);
  $('#editFormfacility_status').val(facility_status);
  $('#editModal').show();
}



function deleteEnrollment(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'enrollments_api?action=delete',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="enrollments"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete enrollment: ' + error, 'error')
              Swal.fire('Error', 'Failed to delete enrollment: ' + xhr.responseText, 'error')
            }
          });
        }
      });
}

function editEnrollment(enrollment_id,student_username,course_code){
  $('#editFormid').val(enrollment_id);
  $('#editFormstudent_username').val(student_username);
  $('#editFormcourse_code').val(course_code);
  $('#editModal').show();
}

function enrollCourse(course_id) {
          $.ajax({
            url: 'enrollments_api?action=enroll',
            type: 'POST',
            data: { course_id},
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="othercourses"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete enrollment: ' + error, 'error')
              Swal.fire('Error', 'Failed to enroll course: ' + xhr.responseText, 'error')
            }
     });
 }

 function enrollModule(module_code) {
          $.ajax({
            url: 'moduleenrollments_api?action=enroll',
            type: 'POST',
            data: { module_code },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="othermodules"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete enrollment: ' + error, 'error')
              Swal.fire('Error', 'Failed to enroll module: ' + xhr.responseText, 'error')
            }
     });
 }

  function unenrollModule(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'moduleenrollments_api?action=unenroll',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="otherenrollments"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete enrollment: ' + error, 'error')
              Swal.fire('Error', 'Failed to delete enrollment: ' + xhr.responseText, 'error')
            }
          });
        }
      });
}

 function unenrollCourse(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'enrollments_api?action=delete',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="otherenrollments"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete enrollment: ' + error, 'error')
              Swal.fire('Error', 'Failed to delete enrollment: ' + xhr.responseText, 'error')
            }
          });
        }
      });
}

function editModule(module_id,code,title,course_code,instructor){
  $('#editFormid').val(module_id);
  $('#editFormcode').val(code);
  $('#editFormtitle').val(title);
  $('#editForminstructor_username').val(instructor);
  $('#editFormcourse_code').val(course_code);
  $('#editModal').show();
}

function editGallery(item_id,description){
  $('#editFormid').val(item_id);
  $('#editFormdescription').val(description);
  $('#editModal').show();
}


function deleteGallery(delete_id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'managegallery_api?action=delete',
            type: 'POST',
            data: { delete_id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="managegallery"]').trigger('click'));
              }else{
                swal.fire({
                    title:"Error",
                    text: response.message,
                    icon:"error",
                    confirmButtonText:'OK'   
                });                
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error','Failed to delete Gallery item: ' + xhr.responseText, 'error')
           }
        });
        }
      });
}

function deletemoduleEnrollment(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'moduleenrollments_api?action=delete',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="instructor_enrollment"]').trigger('click'));
              }else{
                swal.fire("Error",response.message,"error")                
              }
            },
            error: function(xhr, status, error){
              //Swal.fire('Error', 'Failed to delete enrollment: ' + error, 'error')
              Swal.fire('Error', 'Failed to delete enrollment: ' + xhr.responseText, 'error')
            }
          });
        }
      });
}

function editmoduleEnrollment(enrollment_id,student_username,module_code){
  $('#editFormid').val(enrollment_id);
  $('#editFormstudent_username').val(student_username);
  $('#editFormmodule_code').val(module_code);
  $('#editModal').show();
}


function deleteDocument(doc_id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'documents_api?action=delete',
            type: 'POST',
            data: { doc_id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Sccess",response.message,"success").then(() => $('a[data-content="managedocuments"]').trigger('click'));
              }else{
                swal.fire({
                    title:"Error",
                    text: response.message,
                    icon:"error",
                    confirmButtonText:'OK'   
                });                
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error','Failed to delete document: ' + xhr.responseText, 'error')
           }
        });
        }
      });
}


function downloadDocument(doc_id) {
    const url = 'documents_api?id=' + encodeURIComponent(doc_id);
    window.location.href = url;
}

function editStaff(staff_id,fullname,position,description){
  $('#editFormid').val(staff_id);
  $('#editFormfullname').val(fullname);
  $('#editFormposition').val(position);
  $('#editFormdescription').val(description);
  $('#editModal').show();
}


function deleteStaff(delete_id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'staff_api?action=delete',
            type: 'POST',
            data: { delete_id },
            dataType: 'json',
            success: function(response){
              if(response.success){
                swal.fire("Success",response.message,"success").then(() => $('a[data-content="managestaffs"]').trigger('click'));
              }else{
                swal.fire({
                    title:"Error",
                    text: response.message,
                    icon:"error",
                    confirmButtonText:'OK'   
                });                
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error','Failed to delete Gallery item: ' + xhr.responseText, 'error')
           }
        });
        }
      });
}
