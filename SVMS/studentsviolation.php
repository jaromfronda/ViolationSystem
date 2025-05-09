<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card mb-4">
      <h5 class="card-header">Add Student's Violation</h5>
      <div class="card-body">
      <form method="POST" action="functions.php">
        <div class="mt-2 mb-3">
            <label for="Student" class="form-label">Student Name or School ID</label>
                <select id="Student" name="Student" class="form-select select2 form-select-lg">
                    <?php getSelectStudents(); ?>
                </select>
            <div id="defaultFormControlHelp" class="form-text">
                Select Student's Name or Student's School ID
            </div>
        </div>
        <div class="mt-2 mb-3">
        <label for="Violation" class="form-label">Student's Violation</label>
            <select id="Violation" name="Violation" class="form-select select2 form-select-lg">
                <?php getSelectViolation() ?>
            </select>
        <div id="defaultFormControlHelp" class="form-text">
            <?php echo "Today's Student Violations - " . date('F j, Y'); ?>
        </div>
        </div>
        <div class="mt-2 mb-3 text-center">
            <button type="submit" name="SVSubmit" id="SVSubmit" class="btn btn-primary">Submit Student Violation</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <h5 class="card-header">Violators Today <?php echo " - " . date('F j, Y'); ?></h5>
    <div class="table-responsive text-nowrap" style="padding: 20px;">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Violation</th>
                <th>Student ID</th>
                <th>Name</th>
                <th><i class='bx bx-user-circle' ></i></th>
                <th>Course</th>
                <!-- <th>Operation</th> -->
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            <?php
                $sql = "CALL getViolatorsNow()";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    // Convert image blob to base64
                    $imageData = base64_encode($row['img']); // Replace 'ImageBlob' with your actual column name
                    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                ?>
                <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $row['Violation'] ?></strong></td>
                    <td><?= $row['SchoolID'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                                data-bs-toggle="tooltip"
                                data-popup="tooltip-custom"
                                data-bs-placement="top"
                                class="avatar avatar-xs pull-up"
                                title="<?= $row['Name'] ?>"
                            >
                                <img src="<?= $imageSrc ?>" alt="Avatar" class="rounded-circle" />
                            </li>
                        </ul>
                    </td>
                    <td><?= $row['Course'] ?></td>
                </tr>
                <?php } ?>

                <!-- <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"
                        ><i class="bx bx-edit-alt me-1"></i> Edit</a
                    >
                    <a class="dropdown-item" href="javascript:void(0);"
                        ><i class="bx bx-trash me-1"></i> Delete</a
                    >
                    </div>
                </div>
                </td> -->
            </tbody>
        </table>
    </div>
</div>



