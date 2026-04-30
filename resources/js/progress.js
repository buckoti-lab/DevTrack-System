
$(document).ready(function () {
    $('#tasksTable').DataTable();
    // $('#demoTable').DataTable();
});

function openTasksModal(projectId) {
    $.get('/progress/' + projectId + '/tasks', function(tasks) {

        let rows = '';

        $.each(tasks, function(index, task) {
            index++;
            rows += `
            <tr>
                <td>${index}</td>
                <td>${task.title}</td>
                <td>
                    <span class="badge ${task.status === 'done' ? 'bg-success' : 'bg-secondary'}">
                        ${task.status}
                    </span>
                </td>
                <td>
                   <button class="btn btn-sm btn-primary" onclick="openEditTaskModal(${task.id})">
                     Edit
                  </button>
                </td>
            </tr>`;
        });
        $('#taskTable tbody').html(rows);
        $('#tasksModal').modal('show');
    });
}

function openEditTaskModal(taskId){
    $.get('/tasks/' + taskId + '/view', function(task) {
        
        $('#taskId').val(task.id);
        $('#edit_task_title').val(task.title);
        $('#edit_task_assigned_to').val(task.assigned_to);
        $('#edit_task_estimated_hours').val(task.estimated_hours);
        $('#edit_task_description').val(task.description);
        $('#edit_task_priority').val(task.priority);
        $('#edit_task_status').val(task.status);

        $('#editTaskModal').modal('show');
    });

}

function openEditProjectModal(projectId){
    $.get('/project/edit/'+projectId,function(project){

        $("#projectId").val(project.id);
        $("#edit_project_title").val(project.title);
        $("#edit_project_status").val(project.status);

        $("#editProjectModal").modal("show");
    })
}

$("#editTaskForm").on("submit",function (e) {
    e.preventDefault();

    let taskId = $("#taskId").val();
    const formData = new FormData(this);
    formData.append('_method', 'PUT');

    $.ajax({
        url: '/tasks/' + taskId + '/edit',
        type: 'POST',
        data: formData,
        processData:false,
        contentType:false,
        success:function(response){
        if(response.success){
            swal.fire("Success",response.message,"success").then(() => $('a[data-content="progress"]').trigger('click'));
         }else{
           swal.fire("Error",response.message,"error");
         }
      },
      error:function(xhr){
          swal.fire("Error","Internal server error:"+xhr.responseText,"error");
      }
 });
});

$("#editProjectForm").on("submit",function(e){
    e.preventDefault();

   let projectId = $("#projectId").val();
   let status = $("#edit_project_status").val();
   const formData = new FormData(this);

   $.ajax({
      url:"/project/edit/"+projectId+"/"+status,
      type:"PUT",
      processData:false,
      processContent:false,
      success:function(response){
        if(response.success){
            swal.fire("Success",response.message,"success").then(() => $('a[data-content="progress"]').trigger('click'));
         }else{
           swal.fire("Error",response.message,"error");
         }
      },
      error:function(xhr){
          swal.fire("Error","Internal server error:"+xhr.responseText,"error");
      }
   })
})


function openDemoModal(projectId){
        $("#demo_project_id").val(projectId);
        $.get('/demo/' + projectId, function(project_demo) {

        let rows = '';

        $.each(project_demo, function(index, demo) {
            index++;
            rows += `
                    <tr>
                        <td>${index}</td>
                        <td>${demo.description}</td>
                        <td>${demo.type}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="viewDemo(${demo.id})">
                                Preview
                            </button>
                            <button class="btn btn-sm btn-primary"
                                onclick="editDemo(${demo.id})">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                onclick="deleteDemo(${demo.id})">
                                Delete
                            </button>
                        </td>
                    </tr>`;
        });
        $('#demoTable tbody').html(rows);
        // $('#taskTable').html(`<tr><th>#</th><th>Task</th><th>Status</th><th width="100">Actions</th></tr>`+rows);
        $('#demoModal').modal('show');
    });
}


$("#openCreateDemoModal").click(()=>$("#addDemoModal").modal("show"));
$("#openEditDemoModal").click(()=>$("#editDemoModal").modal("show"));
$("#openViewDemoModal").click(()=>$("#viewDemoModal").modal("show"));
 
$("#addDemoForm").on("submit",function(e){
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
        url:"{{ route('demo.store') }}",
        type:"post",
        data:formData,
        dataType:"json",
        processData:false,
        contentType:false,
        success:function(response){
            if(response.success){
                swal.fire("Success",response.message,"success");
            }
        },
        error:function(xhr){
            swal.fire("Error","An error occured"+xhr.responseText,"error");
        }
    })

 })

// ===== DELETE USER =====
 function deleteDemo(demoId){
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if(result.isConfirmed){
            $.ajax({
                url: "/demo/delete/" + demoId,
                type: "DELETE",
                data: {_token: '{{ csrf_token() }}'},
                success: function(response){
                    if(response.success){
                        Swal.fire("Success", response.message, "success");
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function(xhr){
                    Swal.fire("Error", "Failed to delete demo: " + xhr.responseText, "error");
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

$("#editDemoForm").on("submit",function(e){
    e.preventDefault();

    const formData = new FormData(this);
    $.ajax({
        url:"{{ route('demo.edit') }}",
        type:"PUT",
        data:formData,
        contentType:false,
        processData:false,
        success: function(response){
            if(response.success){
                swal.fire("Success",response.message,"success");
            }
        },
        error:function(xhr){
            swal.fire("Error","An error occured: "+xhr.responseText,"error");
        }
    });
})