<title>Manage Documents</title>

<div class="container">

        <h3>Manage Documents</h3>

        <button class="btn-add btn btn-primary" id="openCreateModal">
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
            @foreach($documents as $document) 
             <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $document->name }}</td>
                <td>{{ $document->type }}</td>
                <td>{{ $document->description }}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-view" data-id="{{ $document->id }}">View</button>
                    <button class="btn btn-sm btn-warning btn-edit" data-doc='@json($document)'>Edit</button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $document->id }}">Delete</button>
                </td>
             </tr>
            @endforeach
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

@vite(['resources/js/documents.js'])

