<div class="container">
    <h3 class="mb-4">Projects Progress</h3>
    
    <table id="tasksTable">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Status</th>
            <th>Progress</th>
            <th width="300">Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($projects as $project)
        @if($project->project !== null)
        <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->client_name }}</td>

            <td>
                <span class="badge bg-{{ 
                    $project->project->status === 'completed' ? 'success' :
                    ($project->project->status === 'failed' ? 'danger' : 'warning')
                }}">
                    {{ ucfirst(str_replace('_',' ',$project->project->status)) }}
                </span>
            </td>

            <td>
                <div class="progress">
                    <div class="progress-bar bg-success"
                        style="width: {{ $project->progress_percentage }}%">
                        {{ $project->progress_percentage }}%
                    </div>
                </div>
            </td>

            <td>
                <!-- <button class="btn btn-sm btn-primary"
                    onclick="openTasksModal({{ $project->id }})">
                    View Progress
                </button>

                <button class="btn btn-sm btn-primary"
                    onclick="openEditProjectModal({{ $project->project->id }})">
                    Edit
                </button>

                <button class="btn btn-sm btn-primary"
                    onclick="openDemoModal({{ $project->project->id }})">
                    View Demo
                </button> -->
                <button class="btn btn-sm btn-primary btn-progress-view" data-id="{{ $project->id }}">View Progress</button>
                <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $project->project->id}}">Edit</button>
                <button class="btn btn-sm btn-primary btn-demo-view" data-id="{{ $project->project->id }}">View Demo</button>
            </td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>
</div>

<!-- Tasks Table Modal -->
<div class="modal fade" id="tasksModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Project Tasks</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table id="taskTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="65%">Task</th>
                            <th>Status</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit task</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
               <div class="d-flex">
                 <form id="editTaskForm">
                    @csrf
                    <input type="hidden" id="taskId">
                    <input type="text" disabled readonly name="title" id="edit_task_title" class="form-control form-control-sm me-2">
                    <input type="text" name="assigned_to" id="edit_task_assigned_to" class="form-control form-control-sm me-2" placeholder="Assign task">
                    <input type="text" name="estimated_hours" id="edit_task_estimated_hours" class="form-control form-control-sm me-2"placeholder="Estimated hours">
                    <input type="text" name="description" id="edit_task_description" class="form-control form-control-sm me-2" placeholder="Task description">
                    <select name="priority" class="form-select me-2 form-select-sm task-priority" id="edit_task_priority" required>
                        <option value="low" >Low</option>
                        <option value="medium" >Medium</option>
                        <option value="high">High</option>
                    </select>
                    <select name="status" class="form-control form-control-sm me-2" id="edit_task_status" required>
                        <option value="todo" >todo</option>
                        <option value="in_progress">in_progress</option>
                        <option value="done">done</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                 </form>
                 </div>
            </div>

        </div>
    </div>
</div>


<!-- Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
               <div class="d-flex">
                 <form id="editProjectForm">
                    @csrf
                    <input type="hidden" id="projectId">
                    <input type="text" disabled readonly name="title" id="edit_project_title" class="form-control form-control-sm me-2">
                    <select name="status" class="form-control form-control-sm me-2" id="edit_project_status" required>
                        <option value="in_progress">in_progress</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                 </form>
                 </div>
            </div>

        </div>
    </div>
</div>

<!-- Demo Modal -->
<div class="modal fade" id="demoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Project Demo</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <button class="btn-add" id="openCreateDemoModal">+ Add Demo</button>
                <table id="demoTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="50%">Description</th>
                            <th>Type</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- Add demo Modal -->
<div class="modal fade" id="addDemoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Demo</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
               <div class="d-flex">
                 <form id="addDemoForm">
                    @csrf
                    <input type="hidden" name="demo_project_id" id="demo_project_id">
                    <input type="text" name="description" id="demo_description" class="form-control form-control-sm me-2" placeholder="Demo description">
                    <small><em>Max file size <b>5mb</b>, Allowed files <b>(mp4,jpeg,jpg)</b></em></small>
                    <input type="file" name="file" id="file" placeholder="Upload demo content" required>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                 </form>
                 </div>
            </div>

        </div>
    </div>
</div>

<!-- Edit demo Modal -->
<div class="modal fade" id="editDemoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Demo</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
               <div class="d-flex">
                 <form id="editDemoForm">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="demoId" id="edit_demo_id">
                    <input type="text" name="description" id="edit_demo_description" class="form-control form-control-sm me-2" placeholder="Edit Demo description">
                    <small><em>Max file size <b>10mb</b>, Allowed files <b>(mp4,jpeg,jpg)</b></em></small>
                    <input type="file" name="file" id="edit_demo_file" placeholder="Upload demo content" required>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                 </form>
                 </div>
            </div>

        </div>
    </div>
</div>


<!-- View demo Modal -->
<div class="modal fade" id="viewDemoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Demo Viewer</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
               <div class="d-flex" id="viewDemoContent">
               </div>
            </div>

        </div>
    </div>
</div>

<script>
//   $(".btn-progress-view").on("click",function(){
//     alert("why")
//   })
</script>
@vite(['resources/js/progress.js'])
