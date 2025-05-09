<div class="modal fade" id="AddViolationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="functions.php">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Violation</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                <label for="Violation" class="form-label">Violation Name</label>
                <input type="text" id="Violation" name="Violation" class="form-control" placeholder="Enter Violation Name" required />
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" id="Vsubmit" name="Vsubmit" class="btn btn-primary">Sumit</button>
            </div>
        </form>
    </div>
    </div>
</div>


<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="functions.php" enctype="multipart/form-data">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Student</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="image-upload mt-2 mb-3 d-flex flex-column align-items-center text-center">
                    <img src="assets/img/logo.png" alt="Selected Image" class="img-thumbnail mb-3 image-preview" style="max-height: 200px;" />
                    <input type="file" class="image-input d-none" name="StudentImage" accept="image/*" />
                    <button type="button" class="btn btn-secondary select-image-btn">Select Image</button>
                </div>
                <div class="col mb-3">
                    <label for="StudentSchoolID" class="form-label">School ID</label>
                    <input type="text" id="StudentSchoolID" name="StudentSchoolID" class="form-control" placeholder="Enter School ID" required />
                </div>
                <div class="col mb-3">
                    <label for="StudentName" class="form-label">Student Name</label>
                    <input type="text" id="StudentName" name="StudentName" class="form-control" placeholder="Enter Student Name" required />
                </div>
                <div class="mt-2 mb-3">
                    <label for="Course" class="form-label">Select Course</label>
                        <select id="Course" name="Course" class="form-select select2 form-select-lg">
                            <?php getSelectCourse(); ?>
                        </select>
                    <div id="defaultFormControlHelp" class="form-text">
                        Select Student's Course
                    </div>
                </div>
                <div class="mt-2 mb-3">
                    <label for="Year" class="form-label">Select Year Level</label>
                        <select id="Year" name="Year" class="form-select select2 form-select-lg">
                            <?php getSelectYear(); ?>
                        </select>
                    <div id="defaultFormControlHelp" class="form-text">
                        Select Student's  Year Level
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" id="Ssubmit" name="Ssubmit" class="btn btn-primary">Sumit</button>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="functions.php" enctype="multipart/form-data">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Student</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <input type="hidden" name="EditStudentID" id="EditStudentID" />
            <div class="row">
                <div class="image-upload mt-2 mb-3 d-flex flex-column align-items-center text-center">
                    <img src="assets/img/logo.png" alt="Selected Image" class="img-thumbnail mb-3 image-preview" style="max-height: 200px;" />
                    <input type="file" class="image-input d-none" name="StudentImage" accept="image/*" />
                    <button type="button" class="btn btn-secondary select-image-btn">Select Image</button>
                </div>
                <div class="col mb-3">
                    <label for="EditStudentSchoolID" class="form-label">School ID</label>
                    <input type="text" id="EditStudentSchoolID" name="EditStudentSchoolID" class="form-control" placeholder="Enter School ID" required />
                </div>
                <div class="col mb-3">
                    <label for="EditStudentName" class="form-label">Student Name</label>
                    <input type="text" id="EditStudentName" name="EditStudentName" class="form-control" placeholder="Enter Student Name" required />
                </div>
                <div class="mt-2 mb-3">
                    <label for="EditCourse" class="form-label">Select Course</label>
                        <select id="EditCourse" name="EditCourse" class="form-select select2 form-select-lg">
                            <?php getSelectCourse(); ?>
                        </select>
                    <div id="defaultFormControlHelp" class="form-text">
                        Select Student's Course
                    </div>
                </div>
                <div class="mt-2 mb-3">
                    <label for="EditYear" class="form-label">Select Year Level</label>
                        <select id="EditYear" name="EditYear" class="form-select select2 form-select-lg">
                            <?php getSelectYear(); ?>
                        </select>
                    <div id="defaultFormControlHelp" class="form-text">
                        Select Student's  Year Level
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" id="ESsubmit" name="ESsubmit" class="btn btn-primary">Sumit</button>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="modal fade" id="AddAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="functions.php" enctype="multipart/form-data">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Admin</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="image-upload mt-2 mb-3 d-flex flex-column align-items-center text-center">
                    <img src="assets/img/logo.png" alt="Selected Image" class="img-thumbnail mb-3 image-preview" style="max-height: 200px;" />
                    <input type="file" class="image-input d-none" name="AdminImage" accept="image/*" />
                    <button type="button" class="btn btn-secondary select-image-btn">Select Image</button>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="AdminSchoolID" class="form-label">School ID</label>
                    <input type="text" id="AdminSchoolID" name="AdminSchoolID" class="form-control" placeholder="Enter School ID" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="AdminName" class="form-label">Admin Name</label>
                    <input type="text" id="AdminName" name="AdminName" class="form-control" placeholder="Enter Admin Name" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="AdminPass" class="form-label">Password</label>
                    <input type="password" id="AdminPass" name="AdminPass" class="form-control" placeholder="Enter Password" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="ReAdminPass" class="form-label">Repeat Password</label>
                    <input type="password" id="ReAdminPass" name="ReAdminPass" class="form-control" placeholder="Repeat Password" required />
                    <div id="passMismatch" class="text-danger mt-1 d-none">Passwords do not match</div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" id="Asubmit" name="Asubmit" class="btn btn-primary">Sumit</button>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="modal fade" id="EditAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" action="functions.php" enctype="multipart/form-data">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Admin</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <div class="row">
            <input type="hidden" name="EditAdminID" id="EditAdminID" />
                <div class="image-upload mt-2 mb-3 d-flex flex-column align-items-center text-center">
                    <img src="assets/img/logo.png" alt="Selected Image" class="img-thumbnail mb-3 image-preview" style="max-height: 200px;" />
                    <input type="file" class="image-input d-none" name="AdminImage" accept="image/*" />
                    <button type="button" class="btn btn-secondary select-image-btn">Select Image</button>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="EditAdminSchoolID" class="form-label">School ID</label>
                    <input type="text" id="EditAdminSchoolID" name="EditAdminSchoolID" class="form-control" placeholder="Enter School ID" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="EditAdminName" class="form-label">Admin Name</label>
                    <input type="text" id="EditAdminName" name="EditAdminName" class="form-control" placeholder="Enter Admin Name" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="EditAdminPass" class="form-label">Password</label>
                    <input type="password" id="EditAdminPass" name="EditAdminPass" class="form-control" placeholder="Enter Password" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="ReEditAdminPass" class="form-label">Repeat Password</label>
                    <input type="password" id="ReEditAdminPass" name="ReEditAdminPass" class="form-control" placeholder="Repeat Password" required />
                    <div id="passMismatch" class="text-danger mt-1 d-none">Passwords do not match</div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" id="EAsubmit" name="EAsubmit" class="btn btn-primary">Sumit</button>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" action="functions.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Delete <b id="DelName"></b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="DelID" id="DelID" />
          <input type="hidden" name="DelTable" id="DelTable" />
          <h5>Are you sure you want to delete <b id="DelNamein"></b>?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="Delsubmit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.image-upload').forEach(container => {
    const input = container.querySelector('.image-input');
    const preview = container.querySelector('.image-preview');
    const button = container.querySelector('.select-image-btn');

    button.addEventListener('click', () => {
        input.click();
    });

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});

    const password = document.getElementById('AdminPass');
    const confirmPassword = document.getElementById('ReAdminPass');
    const mismatchMessage = document.getElementById('passMismatch');

    function validatePasswords() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            mismatchMessage.classList.remove('d-none');
        } else {
            confirmPassword.classList.remove('is-invalid');
            mismatchMessage.classList.add('d-none');
        }
    }

    password.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);
</script>
