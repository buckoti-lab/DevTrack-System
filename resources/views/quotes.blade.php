@vite(['resources/css/quote.css'])

<div class="container">

    <h3>Manage Quotes</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('quotes.exportPDF') }}" class="btn-download btn btn-primary">Export PDF</a>

        <button class="btn-add btn-primary" id="openCreateModal">
            + Add Quote
        </button>
    </div>


            <table id="quotes-table">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="200">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($quotes as $quote)
                    <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ $quote->company_name }}</td>
                        <td>{{ $quote->client_name }}</td>
              
                        <td>Tsh {{ number_format($quote->grand_total, 2) }}</td>
            
                        <td>
                            <span class="badge bg-{{ 
                                $quote->status === 'accepted' ? 'success' :
                                ($quote->status === 'rejected' ? 'danger' : 'warning')
                            }}">
                                {{ ucfirst(str_replace('_',' ',$quote->status)) }}
                            </span>
                        </td>
                        <td>{{ $quote->created_at->format('d M Y') }}</td>

                        <td>
                            <button class="btn btn-sm btn-info btn-view" data-id="{{ $quote->id }}">View</button>
                            <button class="btn btn-sm btn-warning btn-edit" data-quote='@json($quote)'>Edit</button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $quote->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
<!--         </div>
    </div> -->

    
<!-- CREATE QUOTE MODAL -->
 <div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add quote</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addForm">
                    @csrf
                    <h6 class="mb-2">Company Information</h6>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Company Name</label>
                            <input type="text" class="form-control" name="company_name"
                                    value="{{ old('company_name') }}">
                            @error('company_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col">
                            <label>Email</label>
                            <input type="text" class="form-control" name="company_email"
                                    value="{{ old('company_email') }}">
                        </div>
                    </div>

                    <h6 class="mt-3">Client Information</h6>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Client Name</label>
                            <input type="text" name="client_name" class="form-control"
                                    value="{{ old('client_name') }}">
                            @error('client_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col">
                            <label>Client Email</label>
                            <input type="text" name="client_email" class="form-control"
                                    value="{{ old('client_email') }}">
                        </div>
                    </div>

                    <h6 class="mt-3">Title</h6>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Project title</label>
                            <input type="text" name="title" class="form-control"
                                    value="{{ old('project_title ') }}">
                            @error('project_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <h6 class="mt-3">Add Items</h6>
                    <div id="items-container">
                        <div class="item-row row mb-2">
                            <div class="col-5">
                                <input type="text" name="items[0][name]" class="form-control" placeholder="Item name">
                            </div>

                            <div class="col-3">
                                <input type="number" name="items[0][quantity]" class="form-control"
                                        placeholder="Qty" min="1">
                            </div>

                            <div class="col-3">
                                <input type="number" name="items[0][price]" class="form-control"
                                        placeholder="Price" step="0.01">
                            </div>

                            <div class="col-1">
                                <button type="button" class="btn btn-danger w-100 removeRow">X</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm" id="addItemRow">+ Add Item</button>

                    <div class="modal-buttons">
                        <input type="submit" value="Submit">
                        <button type="button" class="btn-delete" id="cancelCreate">Cancel</button>
                    </div> 
                </form>


            </div>

        </div>
    </div>
</div>




<!-- EDIT QUOTE MODAL -->
 <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit quote</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="edit_quote_id">

                    <h5 class="text-primary mt-3">Company Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Company Name</label>
                            <input type="text" id="edit_company_name" name="company_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="text" id="edit_company_email" name="company_email" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label>Address</label>
                            <textarea id="edit_company_address" name="company_address" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Contact Number</label>
                            <input type="text" id="edit_company_contact" name="company_contact" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" id="edit_company_date" name="company_date" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <h5 class="text-primary mt-3">Client Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Client Name</label>
                            <input type="text" id="edit_client_name" name="client_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Client Email</label>
                            <input type="text" id="edit_client_email" name="client_email" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label>Client Address</label>
                            <textarea id="edit_client_address" name="client_address" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Contact</label>
                            <input type="text" id="edit_client_contact" name="client_contact" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Quote Valid Date</label>
                            <input type="date" id="edit_quote_valid_date" name="quote_valid_date" class="form-control">
                        </div>
                    </div>

                    <h6 class="mt-3">Title</h6>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Project title</label>
                            <input type="text" name="title" class="form-control"
                                    id="edit_project_title">
                            @error('project_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <hr>

                    <h5 class="text-primary mt-3">Items</h5>
                        <div id="edit-items-container">
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm" id="addEditItemRow">+ Add Item</button>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Tax</label>
                            <input type="number" id="edit_tax" name="tax" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Discount</label>
                            <input type="number" id="edit_discount" name="discount" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control form-control-sm me-2" id="edit_status" required>
                                <option value="pending" >Pending</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <!-- </div> -->

                    <div class="modal-buttons">
                        <input type="submit" value="Save changes">
                        <button type="button" class="btn-delete" id="cancelEdit">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VIEW QUOTE MODAL -->
 <div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Quote Preview</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="viewQuoteContent">
                <!-- AJAX loads PDF-style HTML here -->
                <div class="text-center p-5">
                    <div class="spinner-border text-primary"></div>
                    <p>Loading Quote...</p>
                </div>
            </div>

            <div class="modal-buttons">
                <a id="viewQuotePDF" href="#" class="btn btn-primary">Download pdf</a>
                <button type="button" class="btn-delete" id="closeView">Close</button>
            </div>
        </div>
    </div>
 </div>

 

</div>

</div>

@vite(['resources/js/quote.js'])