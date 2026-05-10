$(document).ready(function(){

    $("#documents-table").DataTable();

    // ====== Buttons ==========
    $(".btn-view").on("click",function(){
        let id = $(this).data("id");
        viewDocument(id);
     });

    $(".btn-edit").on("click",function(){
        let doc_data = $(this).data("doc");
        editDocument(doc_data);
     });

    $(".btn-delete").on("click",function(){
        let id = $(this).data("id");
        deleteDocument(id);
     });


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
                Swal.fire("Error",response.message,"error");
            }  
     },
     error:function(xhr){
        Swal.fire("Error","An error occured!"+xhr.responseText,"error");
     }
    });
}

$("#docFrame").on("load",function(){

    $("#docLoader").hide();
    $("#docFrame").show();

});