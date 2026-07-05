<div class="container">
    <h3>Edit Profile</h3>

    <form id="editprofileForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <small>Change profile image (optional).</small>
        <input type="file" name="profileimage" id="profileimage" class="form-control mb-2">

        <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" class="form-control mb-2" placeholder="First name" required>

        <input type="text" name="second_name" value="{{ Auth::user()->second_name }}" class="form-control mb-2" placeholder="Middle name" required>

        <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" class="form-control mb-2" placeholder="Last name" required>

        <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control mb-2" placeholder="Email" required>

        <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="form-control mb-2" placeholder="Phone number" required>

        <select name="sex" class="form-control mb-3">
            <option value="Male" {{ Auth::user()->sex == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ Auth::user()->sex == 'Female' ? 'selected' : '' }}>Female</option>
        </select>

        <input type="submit" class="btn btn-primary"  value="Update profile">
    </form>
</div>


<script>
$("#editprofileForm").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "update_profile",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (response) {
            if (response.success) {
                Swal.fire("Success!", response.message, "success")
                .then(() => {
                    $('a[data-content="view_profile"]').trigger('click');
                });
            } else {
                Swal.fire("Error!", response.message, "error");
            }
        },

        error: function (xhr) {
            let msg = "Error updating profile.";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }

            Swal.fire("Error!", msg, "error");
        }
    });
});
</script>
