<title>Manage Documents</title>

<div class="container">

        <h3>Manage Documents</h3>

        <button class="btn-add" id="openCreateModal">
            + Add Document
        </button>


    <!-- Documents TABLE -->
    <table id="documents-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($documents as $document) 
             <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $document->name }}</td>
                <td>{{ $document->type }}</td>
                <td>{{ $document->description }}</td>
                <td>
                    <button class="btn btn-sm btn-info"  onclick="viewDocument({{ $document->id }})">View</button>
                    <button class="btn btn-sm btn-warning" onclick="editDocument({{ json_encode($document) }})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteDocument({{ $document->id }})">Delete</button>
                </td>
             </tr>
            @empty
             <tr>
              <td colspan="7" class="text-center py-4">No document found</td>
             </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- CREATE DOCUMENT MODAL -->
 <div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add document</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addForm">
                    @csrf
                    <input type="text" name="name" id="name"  placeholder="Name of the document" required>
                    <select id="type" name="type">
                        <option selected disabled>Document type</option>
                        <option value="functional_requirements">Functional requirement</option>
                        <option value="project_proposal">Project proposal</option>
                        <option value="srs">Project srs</option>
                    </select>
                    <small><em>Max file size <b>5mb</b>, Allowed files <b>(docx,pdf)</b></em></small>
                    <input type="file" name="file" id="file" placeholder="Upload document" required>
                    <small>Content description (optional).</small>
                    <input type="text" name="description" id="description"  placeholder="Document description" required>
                    <div class="modal-buttons">
                        <input type="submit" value="Upload">
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
                <h5 class="modal-title">Edit document</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" id="edit_name"  placeholder="Name of the document" required>
                    <select id="edit_type" name="type">
                        <option selected disabled>Document type</option>
                        <option value="functional_requirements">Functional requirement</option>
                        <option value="project_proposal">Project proposal</option>
                        <option value="srs">Project srs</option>
                    </select>
                    <small><em>Max file size <b>5mb</b>, Allowed files <b>(docx,pdf)</b></em></small>
                    <input type="file" name="file" id="edit_file" placeholder="Upload document" required>
                    <small>Content description (optional).</small>
                    <input type="text" name="description" id="edit_description"  placeholder="Document description" required>
                    <div class="modal-buttons">
                        <input type="submit" value="update">
                        <button type="button" class="btn-delete" id="cancelEdit">Cancel</button>
                    </div> 
                </form>

            </div>

        </div>
    </div>
</div>


<!-- VIEW DOCUMENT MODAL -->
 <div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Document Preview</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Spinner -->
                <div id="docLoader">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Loading document...</p>
                </div>
                <!-- Document Viewer -->
                <embed id="docFrame"
                        width="100%"
                        height="600"
                        style="display:none;border:none;">
            </div>

            <div class="modal-buttons">
                <a id="downloadDocument" href="#" class="btn btn-primary">Download document</a>
                <button type="button" class="btn-delete" id="closeView">Close</button>
            </div>
        </div>
    </div>
 </div>

</div>

<script>
$(document).ready(function(){
    
   $("#documents-table").DataTable();

    // ===== MODAL OPEN/CLOSE =====
    $("#openCreateModal").click(() => $("#createModal").modal("show"));
    $("#cancelCreate").click(() => $("#createModal").modal("hide"));
    $("#cancelEdit").click(() => $("#editModal").modal("hide"));

    // ===== CREATE SCRIPT =====
    $('#addForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('document.store') }}",
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
                Swal.fire('Error', 'Failed to add document: ' + xhr.responseText, 'error');
            }
        });
    });

    // ===== EDIT DOCUMENT SCRIPT =====
    $('#editForm').on('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);

        let documentId = $(this).data('documentId');

        $.ajax({
            url: "/document/update/" + documentId,
            type: 'POST',
            data: formData,
            dataType:"json",
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
                Swal.fire('Error', 'Failed to update document: ' + xhr.responseText, 'error');
            }
        });
    });

}); 


// ===== OPEN EDIT MODAL FUNCTION =====
function editDocument(document){
    $("#edit_name").val(document.name);
    $("#edit_document").val(document.file);
    $("#edit_description").val(document.description);
    $("#edit_type").val(document.type);

    $("#editForm").data('documentId', document.id);

    $("#editModal").modal("show");
}


// ===== DELETE USER =====
function deleteDocument(documentId){
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if(result.isConfirmed){
            $.ajax({
                url: "/document/delete/" + documentId,
                type: "DELETE",
                data: {_token: '{{ csrf_token() }}'},
                dataType:"json",
                success: function(response){
                    if(response.success){
                        Swal.fire("Success", response.message, "success")
                            .then(() => $('a[data-content="documents"]').trigger('click'));
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function(xhr){
                    Swal.fire("Error", "Failed to delete Document: " + xhr.responseText, "error");
                }
            });
        }
    });
}


function viewDocument(documentId) {

    $("#viewModal").modal("show");
    // show spinner
    $("#docLoader").show();

    $.ajax({
        url: "/document/view/" + documentId,
        type:"get",
        dataType:"json",
        success: function(response){        
              if(response.success){

                let file = response.file;

                if(file.endsWith(".docx")){
                    file = "https://docs.google.com/gview?url=" + file + "&embedded=true";
                }

                $("#docFrame").attr("src",file);
                $("#downloadDocument").attr("href",response.file);
                $("#docFrame").show();

            }else{
                swal.fire("Error",response.message,"error");
            }  
     },
     error:function(xhr){
        swal.fire("Error","An error occured!"+xhr.responseText,"error");
     }
    });
}

$("#docFrame").on("load",function(){

    $("#docLoader").hide();
    $("#docFrame").show();

});
</script>

