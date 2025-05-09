<div class="card">
    <h5 class="card-header">Admin Records</h5>
    <div class="text-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddAdminModal">
            <span class="tf-icons bx bx-user-plus"></span>&nbsp; Add Admin
        </button>
    </div>
    <div class="table-responsive text-nowrap" style="padding: 20px;">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><i class='bx bx-user-circle' ></i></th>
                <th>School ID</th>
                <th>Name</th>
                <!-- <th>Role</th> -->
                <th>Operation</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            <?php
                $sql = "SELECT
                            `user`.*
                        FROM
                            `user`";
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
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item editAdminBtn"
                                href="javascript:void(0);"
                                data-id="<?= $row['ID'] ?>"
                                data-schoolid="<?= htmlspecialchars($row['SchoolID']) ?>"
                                data-name="<?= htmlspecialchars($row['Name']) ?>"
                                data-pass="<?= htmlspecialchars($row['Password']) ?>"
                                data-img="<?= $imageSrc ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#EditAdminModal">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <a class="dropdown-item"
                                href="javascript:void(0);"
                                onclick="deleteItem('user', '<?= htmlspecialchars($row['ID']) ?>', '<?= htmlspecialchars($row['Name']) ?>')"
                                data-bs-toggle="modal"
                                data-bs-target="#DeleteModal">
                                <i class="bx bx-trash me-1"></i> Delete
                            </a>


                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <script>
                function deleteItem(table, id, name) {
                    console.log("Delete called with:", table, id, name); // For testing
                    document.getElementById('DelTable').value = table;
                    document.getElementById('DelID').value = id;
                    document.getElementById('DelName').innerHTML  = name;
                    document.getElementById('DelNamein').innerHTML  = name;
                }

                document.querySelectorAll('.editAdminBtn').forEach(button => {
                    button.addEventListener('click', () => {
                        document.getElementById('EditAdminID').value = button.dataset.id;
                        document.getElementById('EditAdminSchoolID').value = button.dataset.schoolid;
                        document.getElementById('EditAdminName').value = button.dataset.name;
                        document.getElementById('EditAdminPass').value = button.dataset.pass;
                        document.getElementById('ReEditAdminPass').value = button.dataset.pass;

                        const preview = document.querySelector('#EditAdminModal .image-preview');
                        preview.src = button.dataset.img || 'assets/img/logo.png';
                    });
                });
            </script>

            </tbody>
        </table>
    </div>
</div>



