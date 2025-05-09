<div class="card">
    <h5 class="card-header">Student Records</h5>
    <div class="text-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddStudentModal">
            <span class="tf-icons bx bx-user-plus"></span>&nbsp; Add Students
        </button>
    </div>
    <div class="table-responsive text-nowrap" style="padding: 20px;">
        <!-- <div class="demo-inline-spacing text-center" >
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div> -->
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><i class='bx bx-user-circle' ></i></th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Year Level</th>
                <th>Course</th>
                <th>Department</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            <?php
                $sql = "CALL getStudentData();";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    // Detect MIME type if stored (e.g. in a 'mime_type' column), else default to jpeg
                    $mimeType = !empty($row['mime_type']) ? $row['mime_type'] : 'image/jpeg';

                    // Create image source or fallback
                    $imageSrc = $row['img']
                        ? 'data:' . $mimeType . ';base64,' . base64_encode($row['img'])
                        : 'assets/img/logo.png';
                ?>
                <tr>
                    <td>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                                data-bs-toggle="tooltip"
                                data-popup="tooltip-custom"
                                data-bs-placement="top"
                                class="avatar avatar-xs pull-up"
                                title="<?= htmlspecialchars($row['Name']) ?>"
                            >
                                <img src="<?= $imageSrc ?>" alt="Avatar" class="rounded-circle" />
                            </li>
                        </ul>
                    </td>
                    <td><strong><?= htmlspecialchars($row['SchoolID']) ?></strong></td>
                    <td><?= htmlspecialchars($row['Name']) ?></td>
                    <td><?= htmlspecialchars($row['YearLevel']) ?></td>
                    <td title="<?= htmlspecialchars($row['Desc']) ?>">
                        <?= htmlspecialchars($row['Course']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['Department']) ?></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item editStudentBtn"
                                href="javascript:void(0);"
                                data-id="<?= $row['StudentID'] ?>"
                                data-schoolid="<?= htmlspecialchars($row['SchoolID']) ?>"
                                data-name="<?= htmlspecialchars($row['Name']) ?>"
                                data-course="<?= $row['CourseID'] ?>"
                                data-year="<?= $row['YearID'] ?>"
                                data-img="<?= $imageSrc ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#EditStudentModal">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <script>
                document.querySelectorAll('.editStudentBtn').forEach(button => {
                    button.addEventListener('click', () => {
                        document.getElementById('EditStudentID').value = button.dataset.id;
                        document.getElementById('EditStudentSchoolID').value = button.dataset.schoolid;
                        document.getElementById('EditStudentName').value = button.dataset.name;

                        $('#EditCourse').val(button.dataset.course).trigger('change');
                        $('#EditYear').val(button.dataset.year).trigger('change');

                        const preview = document.querySelector('#EditStudentModal .image-preview');
                        preview.src = button.dataset.img || 'assets/img/logo.png';
                    });
                });
            </script>

            </tbody>
        </table>
    </div>
</div>



