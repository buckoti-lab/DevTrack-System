$(document).ready(function () {
    
    $('#quotes-table').DataTable();

    // =======================
    // OPEN / CLOSE MODALS
    // =======================

    $("#openCreateModal").click(() => $("#createModal").modal("show"));
    $("#cancelCreate").click(() => $("#createModal").modal("hide"));
    $("#cancelEdit").click(() => $("#editModal").modal("hide"));
    $("#closeView").click(() => $("#viewModal").modal("hide"));


    $('#addForm').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('quotes.store') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire("Success", response.message, "success")
                        .then(() => $('a[data-content="quotes"]').trigger('click'));
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function (xhr) {
                Swal.fire('Error', 'Failed to add quote: ' + xhr.responseText, 'error');
            }
        });
    });


    // =======================
    // EDIT QUOTE
    // =======================

    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        alert("Hey aa!");

        let quoteId = $("#edit_quote_id").val();

        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: "/quotes/update/" + quoteId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire("Updated!", response.message, "success")
                        .then(() => $('a[data-content="quotes"]').trigger('click'));
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function (xhr) {
                Swal.fire("Error", "Failed to update quote: " + xhr.responseText, "error");
            }
        });
    });

}); 





// =====================
// OPEN EDIT MODAL
// =====================

function editQuote(q) {

   if(q.status == "accepted"){
      $("#edit_status").prop("disabled", true).addClass("bg-light text-muted");                    
   }


    $("#edit_quote_id").val(q.id);

    $("#edit_company_name").val(q.company_name);
    $("#edit_company_address").val(q.company_address);
    $("#edit_company_email").val(q.company_email);
    $("#edit_company_contact").val(q.company_contact);
    $("#edit_company_date").val(q.company_date);

    $("#edit_client_name").val(q.client_name);
    $("#edit_client_address").val(q.client_address);
    $("#edit_client_email").val(q.client_email);
    $("#edit_client_contact").val(q.client_contact);
    $("#edit_quote_valid_date").val(q.quote_valid_date);

    $("#edit_project_title").val(q.project_title);

    $("#edit_tax").val(q.tax);
    $("#edit_discount").val(q.discount);
    $("#edit_status").val(q.status);

    $("#edit-items-container").html("");

    q.items  = JSON.parse(q.items);

    q.items.forEach((item, i) => {

          $("#edit-items-container").append(`
                      <div class="item-row row mb-2">
                        <div class="col-5">
                            <input class="form-control item_name" name="items[${i}][name]" value="${item.item}">
                        </div>

                        <div class="col-3">
                            <input class="form-control item_qty" name="items[${i}][qty]" value="${item.qty}">
                        </div>

                        <div class="col-3">
                           <input class="form-control item_price" name="items[${i}][price]" value="${item.price}">
                        </div>

                        <div class="col-1">
                            <button type="button" class="btn btn-danger w-100 removeItemRow">&times;</button>
                        </div>
                    </div>
          `);
    });



    $("#edit_tax").val(q.tax);
    $("#edit_discount").val(q.discount);

     $("#editModal").modal("show");
       
}



// =====================
// DELETE QUOTE
// =====================

function deleteQuote(quoteId) {

    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then(result => {

        if (result.isConfirmed) {

            $.ajax({
                url: "/quotes/delete/" + quoteId,
                type: "DELETE",
                data: {_token: '{{ csrf_token() }}'},
                success: function (response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.message, "success")
                            .then(() => $('a[data-content="quotes"]').trigger('click'));
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function (xhr) {
                    Swal.fire("Error", "Failed to delete quote: " + xhr.responseText, "error");
                }
            });

        }

    });

}



// =====================
// VIEW QUOTE
// =====================

function viewQuote(quoteId) {

    $("#viewQuoteContent").html(`
        <div class='text-center p-5'>
            <div class='spinner-border text-primary'></div>
            <p>Loading...</p>
        </div>
    `);

    $("#viewQuotePDF").attr("href", "/quotes/pdf/" + quoteId);

    $.get("/quotes/view/" + quoteId, function (html) {
        $("#viewQuoteContent").html(html);
    });

    $("#viewModal").modal("show");
}



// =====================
// ADD ITEM ROWS
// =====================
$(document).ready(function(){
    let AddItemIndex = 1;
    let EditItemIndex = 1;


$("#addItemRow").click(function () {

    $("#items-container").append(`
        <div class="item-row row mb-2">
            <div class="col-5">
                <input type="text" name="items[${AddItemIndex}][name]" class="form-control" placeholder="Item name">
            </div>

            <div class="col-3">
                <input type="number" name="items[${AddItemIndex}][quantity]" class="form-control" placeholder="Qty">
            </div>

            <div class="col-3">
                <input type="number" name="items[${AddItemIndex}][price]" class="form-control" placeholder="Price">
            </div>

            <div class="col-1">
                <button type="button" class="btn btn-danger w-100 removeItemRow">X</button>
            </div>
        </div>
    `);
    AddItemIndex++;
});

$("#addEditItemRow").click(function () {

    $("#edit-items-container").append(`
        <div class="item-row row mb-2">
            <div class="col-5">
                <input type="text" name="items[${EditItemIndex}][name]" class="form-control" placeholder="Item name">
            </div>

            <div class="col-3">
                <input type="number" name="items[${EditItemIndex}][quantity]" class="form-control" placeholder="Qty">
            </div>

            <div class="col-3">
                <input type="number" name="items[${EditItemIndex}][price]" class="form-control" placeholder="Price">
            </div>

            <div class="col-1">
                <button type="button" class="btn btn-danger w-100 removeItemRow">X</button>
            </div>
        </div>
    `);

    EditItemIndex++;
});

});

$(document).on("click", ".removeItemRow", function () {
    $(this).closest(".item-row").remove();
}); 


