<title>Manage Users</title>

<div class="container">

        <h3>Manage Users</h3>

        <!-- <button class="btn-add" id="openCreateModal">+ Add User</button> -->
        <!-- <a href="{{ route('users.exportPDF') }}" class="btn-download">Export PDF</a> -->

    <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('users.exportPDF') }}" class="btn-download btn btn-primary">Export PDF</a>

        <button class="btn-add btn-primary" id="openCreateModal">
            + Add User
        </button>
    </div>

    <!-- USERS TABLE -->
    <table id="users-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Phone</th>
                <th>Role</th>
                <th>SDMS ID</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user) 
             <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->first_name }} {{ $user->second_name }} {{ $user->last_name }}</td>
                <td>{{ $user->sex }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->role }}</td>
                <!-- <td>{{ $user->created_at->format('Y-m-d') }}</td> -->
                 <td>{{ $user->sdms_id }}</td>
                <td>
                    <button class="btn-edit" onclick='editUser({{ json_encode($user) }})'>Edit</button>
                    <button class="btn-delete" onclick="deleteUser({{ $user->id }})">Delete</button>
                </td>
             </tr>
            @empty
             <tr>
              <td colspan="7" class="text-center py-4">No user found</td>
             </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- CREATE USER MODAL -->
 <div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add user</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addForm">
                    @csrf
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="second_name" placeholder="Second Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <select name="sex" required>
                        <option value="">Sex...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select name="role" required>
                        <option value="">Role...</option>
                        <option value="admin">Admin</option>
                        <option value="developer">Developer</option>
                        <option value="client">client</option>
                    </select>
                    <input type="text" name="phone" placeholder="Phone">
                    <input type="password" name="password" placeholder="Password" required>
                    <div class="modal-buttons">
                        <input type="submit" value="Submit">
                        <button type="button" class="btn-delete" id="cancelCreate">Cancel</button>
                    </div> 
                </form>

            </div>

        </div>
    </div>
</div>

<!-- EDIT MODAL -->
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit user</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="text" name="first_name" id="edit_first_name" required>
                    <input type="text" name="second_name" id="edit_second_name" required>
                    <input type="text" name="last_name" id="edit_last_name" required>
                    <input type="email" name="email" id="edit_email" required>
                    <select name="sex" id="edit_sex" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select name="role" id="edit_role" required>
                        <option value="admin">Admin</option>
                        <option value="developer">Developer</option>
                        <option value="client">Client</option>
                    </select>
                    <input type="text" name="phone" id="edit_phone">
                    <div class="modal-buttons">
                    <input type="submit" value="Submit">
                    <button type="button" class="btn-delete" id="cancelEdit">Cancel</button>
                    </div> 
                </form>

            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    $("#users-table").DataTable();



    // ========== AJAX LIVE SEARCH ==========
    $("#searchBtn").click(function () {
        let query = $("#searchInput").val();

        $.ajax({
            url: "{{ route('users.index') }}",
            type: "GET",
            data: { search: query },
            success: function(response) {

                $("#users-table tbody").empty();

                if(response.users.length === 0){
                    $("#users-table tbody").append(`
                        <tr><td colspan="8" style="text-align:center;">No users found</td></tr>
                    `);
                    return;
                }

                $.each(response.users, function(index, user){
                    $("#users-table tbody").append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${user.email}</td>
                            <td>${user.first_name} ${user.second_name} ${user.last_name}</td>
                            <td>${user.sex}</td>
                            <td>${user.phone ?? ''}</td>
                            <td>${user.role}</td>
                            <td>${user.sdms_id}</td>
                            <td>
                                <button class="btn-edit" onclick='editUser(${JSON.stringify(user)})'>Edit</button>
                                <button class="btn-delete" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        </tr>
                    `);
                });


                $('#users-table').DataTable({
                    paging: true,      
                    searching: true,   
                    ordering: true,    
                    responsive: true   
                });
            }
        });
    });


    // ===== MODAL OPEN/CLOSE =====
    $("#openCreateModal").click(() => $("#createModal").modal("show"));
    $("#cancelCreate").click(() => $("#createModal").modal("hide"));
    $("#cancelEdit").click(() => $("#editModal").modal("hide"));

    // ===== CREATE USER =====
    $('#addForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('users.store') }}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success){
                    Swal.fire("Success", response.message, "success");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function(xhr){
                Swal.fire('Error', 'Failed to add user: ' + xhr.responseText, 'error');
            }
        });
    });

    // ===== EDIT USER =====
    $('#editForm').on('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        let userId = $(this).data('userId');

        $.ajax({
            url: "/users/update/" + userId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success){
                    Swal.fire("Success", response.message, "success");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function(xhr){
                Swal.fire('Error', 'Failed to update user: ' + xhr.responseText, 'error');
            }
        });
    });

}); 




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

    $("#editModal").modal("show");
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
                        Swal.fire("Success", response.message, "success")
                            .then(() => $('a[data-content="users"]').trigger('click'));
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
</script>

