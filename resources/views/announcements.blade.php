<div class="container">
    
    <h3>Manage Announcements</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('announcements.exportPDF') }}" class="btn-download btn btn-primary">Export PDF</a>

        <button class="btn-add btn btn-primary" id="openCreateModal">
            + Add Announcement
        </button>
    </div>


    <!-- ANNOUNCEMENTS TABLE -->
    <table id="announcements-table">
        <thead>
            <tr>
                <th>S/N</th>
                <th>content</th>
                <th>Publish date</th>
                <th>Expire date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
             @foreach($announcements as $announcement)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $announcement->content }}</td>
                <td>{{ $announcement->created_at->format('Y-m-d') }}</td>
                <td>{{ $announcement->expires_at }}</td>
                <td>
                    <button class="btn-edit" onclick='editAnnouncement({{ json_encode($announcement) }})'>Edit</button>
                    <button class="btn-delete" onclick="deleteAnnouncement({{ $announcement->id }})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- CREATE ANNOUNCEMENT MODAL -->
 <div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add announcement</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addForm">
                    @csrf
                    <textarea name="content" id="content" style="resize:none;" placeholder="Add content here." required></textarea>
                    <select name="target" id="target" required>
                    <option value="" selected disabled>Select target</option>
                        <option value="Admin" >Admin</option>
                        <option value="Other">Developer</option>
                        <option value="Other">Client</option>
                    </select>
                    <input type="datetime-local" id="expires_at" name="expires_at" required> 
                    <div class="modal-buttons">
                    <input type="submit" value="Submit">
                    <button type="button" class="btn-delete" id="cancelCreate">Cancel</button>
                    </div> 
                </form>


            </div>

        </div>
    </div>
</div>

<!-- EDIT ANNOUNCEMENT MODAL -->
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit announcement</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <textarea name="content" id="edit_content" style="resize:none;"></textarea>
                    <select name="target" id="edit_target">
                        <option value="" selected disabled>Select target</option>
                        <option value="Admin" >Admin</option>
                        <option value="Other">Other</option>
                    </select>
                    <input type="datetime-local" id="edit_expires_at" name="expires_at">
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

   $("#announcements-table").DataTable();


    // ===== MODAL OPEN/CLOSE =====
    $("#openCreateModal").click(() => $("#createModal").modal("show"));
    $("#cancelCreate").click(() => $("#createModal").modal("hide"));
    $("#cancelEdit").click(() => $("#editModal").modal("hide"));


    // ===== CREATE ANNOUNCEMENT =====
    $('#addForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('announcements.store') }}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success){
                    Swal.fire("Success", response.message, "success")
                        .then(() => $('a[data-content="announcements"]').trigger('click'));
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function(xhr){
                Swal.fire('Error', 'Failed to add announcement: ' + xhr.responseText, 'error');
            }
        });
    });

    // ===== EDIT ANNOUNCEMENT =====
    $('#editForm').on('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);
        //formData.append('_method', 'PUT');

        let announcementId = $(this).data('announcementId');

        $.ajax({
            url: "/announcements/update/" + announcementId,
            type: 'PUT',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success){
                    Swal.fire("Success", response.message, "success")
                        .then(() => $('a[data-content="announcements"]').trigger('click'));
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function(xhr){
                Swal.fire('Error', 'Failed to update announcement: ' + xhr.responseText, 'error');
            }
        });
    });

});



// ===== OPEN EDIT MODAL FUNCTION =====
function editAnnouncement(announcement){
    $("#edit_content").val(announcement.content);
    $("#edit_target").val(announcement.target);
    $("#edit_expires_at").val(announcement.expires_at);

    $("#editForm").data('announcementId', announcement.id);

    // $("#editModal").fadeIn();
    $("#editModal").modal("show");
}


// ===== DELETE ANNOUNCEMENT =====
function deleteAnnouncement(announcementId){
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if(result.isConfirmed){
            $.ajax({
                url: "/announcements/delete/" + announcementId,
                type: "DELETE",
                data: {_token: '{{ csrf_token() }}'},
                success: function(response){
                    if(response.success){
                        Swal.fire("Success", response.message, "success")
                            .then(() => $('a[data-content="announcements"]').trigger('click'));
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function(xhr){
                    Swal.fire("Error", "Failed to delete announcement: " + xhr.responseText, "error");
                }
            });
        }
    });
}
</script>

