

<?php

require_once "config.php"; 


error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['Signin']))
{
    $schoolID = $conn->real_escape_string($_POST['schoolID']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "CALL getUser('$schoolID')";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['Password']) {
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['SchoolID'] = $user['SchoolID'];
            $_SESSION['img'] = 'data:image/jpeg;base64,' . base64_encode($user['img']);
            header("Location: index.php");
            exit();
        } else {
            setAlertMessage("Invalid School ID or Password.", "danger");
            header("Location: account");
            exit();
        }
    } else {
        setAlertMessage("Invalid School ID or Password.", "danger");
        header("Location: account");
        exit();
    }
}

if (isset($_POST['Vsubmit'])) {
    $violation = $conn->real_escape_string($_POST['Violation']);

    $checkSql = "SELECT * FROM violation WHERE Violation = '$violation'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        setAlertMessage("This violation already exists.", "warning");
    } else {
        $sql = "INSERT INTO violation (Violation) VALUES ('$violation')";
        if ($conn->query($sql) === TRUE) {
            setAlertMessage("Violation added successfully.", "success");
        } else {
            setAlertMessage("Error: " . $conn->error, "danger");
        }
    }

    header("Location: index.php?Violation=0");
    exit();
}

if (isset($_POST['SVSubmit'])) {
    $violationID = trim($_POST['Violation'] ?? '');
    $studentID = trim($_POST['Student'] ?? '');

    if (empty($violationID) || empty($studentID)) {
        setAlertMessage("Please select both a student and a violation.", "warning");
    } else {
        $stmt = $conn->prepare("INSERT INTO violationreport (ViolationID, StudentID) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ii", $violationID, $studentID);
            if ($stmt->execute()) {
                setAlertMessage("Student violation recorded successfully.", "success");
            } else {
                setAlertMessage("Database error: " . $stmt->error, "danger");
            }
            $stmt->close();
        } else {
            setAlertMessage("Database preparation error: " . $conn->error, "danger");
        }
    }

    header("Location: index.php?StudentsViolation");
    exit();
}

if (isset($_POST['Ssubmit'])) {
    // Retrieve form data
    $StudentSchoolID = trim($_POST['StudentSchoolID'] ?? '');
    $StudentName = trim($_POST['StudentName'] ?? '');
    $Course = trim($_POST['Course'] ?? '');
    $Year = trim($_POST['Year'] ?? '');
    $imageFile = $_FILES['StudentImage'] ?? null;

    if (empty($StudentSchoolID) || empty($StudentName) || empty($Course) || empty($Year) || !$imageFile) {
        setAlertMessage("All fields and image are required.", "warning");
    } else {
        // Check if the School ID already exists
        $checkStmt = $conn->prepare("SELECT StudentID FROM student WHERE SchoolID = ?");
        $checkStmt->bind_param("s", $StudentSchoolID);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            setAlertMessage("The School ID already exists. Please use a unique ID.", "danger");
        } else {
            // Handle the Image Upload if there is an image
            if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
                $imgData = file_get_contents($imageFile['tmp_name']); // Read image data

                // Insert the image data into the img table
                $imgStmt = $conn->prepare("INSERT INTO img (img) VALUES (?)");
                if ($imgStmt) {
                    $imgStmt->bind_param("b", $imgData);
                    $imgStmt->send_long_data(0, $imgData); // Send large data

                    if ($imgStmt->execute()) {
                        $imgID = $conn->insert_id; // Get the image ID after insertion
                    } else {
                        setAlertMessage("Failed to save image: " . $imgStmt->error, "danger");
                    }

                    $imgStmt->close();
                } else {
                    setAlertMessage("Failed to prepare image insertion query.", "danger");
                }
            }else {
                $imgID = 1;
            }

            // Insert student details into the student table with the image ID
            $insertStmt = $conn->prepare("INSERT INTO student (SchoolID, `Name`, CourseID, YearID, img) VALUES (?, ?, ?, ?, ?)");
            if ($insertStmt) {
                $insertStmt->bind_param("ssiii", $StudentSchoolID, $StudentName, $Course, $Year, $imgID);
                if ($insertStmt->execute()) {
                    setAlertMessage("Student has been added successfully.", "success");
                } else {
                    setAlertMessage("Failed to add student: " . $insertStmt->error, "danger");
                }
                $insertStmt->close();
            } else {
                setAlertMessage("Failed to prepare student insertion query.", "danger");
            }
        }

        $checkStmt->close();
    }

    // Redirect after processing the form
    header("Location: index.php?Students");
    exit();
}

if (isset($_POST['ESsubmit'])) {
    $StudentID = trim($_POST['EditStudentID'] ?? '');
    $StudentSchoolID = trim($_POST['EditStudentSchoolID'] ?? '');
    $StudentName = trim($_POST['EditStudentName'] ?? '');
    $Course = trim($_POST['EditCourse'] ?? '');
    $Year = trim($_POST['EditYear'] ?? '');
    $imageFile = $_FILES['StudentImage'] ?? null;

    if (empty($StudentID) || empty($StudentSchoolID) || empty($StudentName) || empty($Course) || empty($Year)) {
        setAlertMessage("All fields except image are required.", "warning");
    } else {
        $checkStmt = $conn->prepare("SELECT StudentID FROM student WHERE SchoolID = ? AND StudentID != ?");
        $checkStmt->bind_param("si", $StudentSchoolID, $StudentID);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            setAlertMessage("The School ID already exists for another student.", "danger");
        } else {
            $imgID = null;

            if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
                $imgData = file_get_contents($imageFile['tmp_name']);

                $imgStmt = $conn->prepare("INSERT INTO img (img) VALUES (?)");
                if ($imgStmt) {
                    $imgStmt->bind_param("b", $imgData);
                    $imgStmt->send_long_data(0, $imgData);

                    if ($imgStmt->execute()) {
                        $imgID = $conn->insert_id;
                    } else {
                        setAlertMessage("Failed to save image: " . $imgStmt->error, "danger");
                    }

                    $imgStmt->close();
                } else {
                    setAlertMessage("Failed to prepare image update query.", "danger");
                }
            }

            if ($imgID) {
                $updateStmt = $conn->prepare("UPDATE student SET SchoolID = ?, `Name` = ?, CourseID = ?, YearID = ?, img = ? WHERE StudentID = ?");
                $updateStmt->bind_param("ssiiii", $StudentSchoolID, $StudentName, $Course, $Year, $imgID, $StudentID);
            } else {
                $updateStmt = $conn->prepare("UPDATE student SET SchoolID = ?, `Name` = ?, CourseID = ?, YearID = ? WHERE StudentID = ?");
                $updateStmt->bind_param("ssiii", $StudentSchoolID, $StudentName, $Course, $Year, $StudentID);
            }

            if ($updateStmt->execute()) {
                setAlertMessage("Student updated successfully.", "success");
            } else {
                setAlertMessage("Failed to update student: " . $updateStmt->error, "danger");
            }

            $updateStmt->close();
        }

        $checkStmt->close();
    }
    header("Location: index.php?Students");
    exit();
}

if (isset($_POST['Asubmit'])) {
    $AdminSchoolID = trim($_POST['AdminSchoolID'] ?? '');
    $AdminName     = trim($_POST['AdminName'] ?? '');
    $AdminPass     = $_POST['AdminPass'] ?? '';
    $ReAdminPass   = $_POST['ReAdminPass'] ?? '';
    $imageFile     = $_FILES['AdminImage'] ?? null;

    if (empty($AdminSchoolID) || empty($AdminName) || empty($AdminPass) || empty($ReAdminPass)) {
        setAlertMessage("All fields are required.", "warning");
    } elseif ($AdminPass !== $ReAdminPass) {
        setAlertMessage("Passwords do not match.", "danger");
    } else {
        $checkStmt = $conn->prepare("SELECT ID FROM user WHERE SchoolID = ?");
        $checkStmt->bind_param("s", $AdminSchoolID);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            setAlertMessage("School ID already exists.", "danger");
        } else {
            $imgData = null;
            if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
                $imgData = file_get_contents($imageFile['tmp_name']);
            }

            $insertStmt = $conn->prepare("INSERT INTO user (SchoolID, Name, Password, img) VALUES (?, ?, ?, ?)");
            $null = NULL;
            $insertStmt->bind_param("sssb", $AdminSchoolID, $AdminName, $AdminPass, $null);

            if ($imgData) {
                $insertStmt->send_long_data(3, $imgData);
            }

            if ($insertStmt->execute()) {
                setAlertMessage("Admin has been added successfully.", "success");
            } else {
                setAlertMessage("Failed to add admin: " . $insertStmt->error, "danger");
            }

            $insertStmt->close();
        }

        $checkStmt->close();
    }

    header("Location: index.php?Admin");
    exit();
}

if (isset($_POST['EAsubmit'])) {
    $adminID      = intval($_POST['EditAdminID'] ?? 0);
    $schoolID     = trim($_POST['EditAdminSchoolID'] ?? '');
    $adminName    = trim($_POST['EditAdminName'] ?? '');
    $adminPass    = $_POST['EditAdminPass'] ?? '';
    $reAdminPass  = $_POST['ReEditAdminPass'] ?? '';
    $imageFile    = $_FILES['AdminImage'] ?? null;

    if($_SESSION['SchoolID'] = $schoolID)

    if (empty($schoolID) || empty($adminName) || empty($adminPass) || empty($reAdminPass)) {
        setAlertMessage("All fields are required.", "warning");
    } elseif ($adminPass !== $reAdminPass) {
        setAlertMessage("Passwords do not match.", "danger");
    } else {
        $imgData = null;
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $imgData = file_get_contents($imageFile['tmp_name']);
        }

        if ($imgData) {
            $updateStmt = $conn->prepare("UPDATE user SET SchoolID = ?, Name = ?, Password = ?, img = ? WHERE ID = ?");
            $null = NULL;
            $updateStmt->bind_param("sssbi", $schoolID, $adminName, $adminPass, $null, $adminID);
            $updateStmt->send_long_data(3, $imgData);
        } else {
            $updateStmt = $conn->prepare("UPDATE user SET SchoolID = ?, Name = ?, Password = ? WHERE ID = ?");
            $updateStmt->bind_param("sssi", $schoolID, $adminName, $adminPass, $adminID);
        }

        if ($updateStmt->execute()) {
            setAlertMessage("Admin updated successfully.", "success");
        } else {
            setAlertMessage("Failed to update admin: " . $updateStmt->error, "danger");
        }

        $updateStmt->close();
    }
    if($_SESSION['SchoolID'] != $schoolID)
    {
        header("Location: index.php?Admin");
    }else
    {
        setAlertMessage("There is some changer in your account please login again.", "info");
        header("Location: account");
    }
    exit();
}


/////////////////////////////////////////////////////////

function getViolation($violationID)
{
    global $conn;
    $monthlyCounts = [];
    $total = 0;

    // Start with an empty WHERE clause
    $whereClause = '';

    // If violationID is not 0, include the ViolationID filter
    if ($violationID != 0) {
        $whereClause = "ViolationID = $violationID AND ";
    }

    // Loop through all months to get counts
    for ($month = 1; $month <= 12; $month++) {
        // Construct the SQL query for each month
        $sql = "SELECT COUNT(*) as count
                FROM violationreport
                WHERE $whereClause
                MONTH(TimeStamp) = $month
                AND YEAR(TimeStamp) = YEAR(CURDATE())";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = (int)$row['count'];
        $monthlyCounts[] = $count;
        $total += $count;
    }

    // Return the total + monthly data
    return array_merge(['', $total], $monthlyCounts);
}



function echoViolation()
{
    echo
    "
    <div class='col-md-12 col-lg-12 order-1 mb-12'>
        <div class='card h-100'>
        <div class='card-header'>
            <ul class='nav nav-pills' role='tablist'>
            </ul>
        </div>
        <div class='card-body px-0'>
            <div class='tab-content p-0'>
            <div class='tab-pane fade show active' id='navs-tabs-line-card-income' role='tabpanel'>
                <div class='d-flex p-4 pt-3'>
                <div class='avatar flex-shrink-0 me-3'>
                    <img src='assets/img/logo.png' alt='User' />
                </div>
                <div>
                    <small class='text-muted d-block'>Total Violators this year @ <script> document.write(new Date().getFullYear());</script></small>
                </div>
                </div>
                <div id='incomeChart'></div>
                <div class='d-flex justify-content-center pt-4 gap-2'>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    ";
}

function getSelectStudents()
{
    global $conn;

    $sql = "SELECT StudentID, Name, SchoolID FROM student";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<option disabled selected>Select Student</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['StudentID'] . '">' . htmlspecialchars($row['Name']) . ' (' . htmlspecialchars($row['SchoolID']) . ')</option>';
        }
    } else {
        echo '<option disabled>No students found</option>';
    }
}

function getSelectViolation()
{
    global $conn;

    if (!$conn) {
        echo '<option disabled>Database connection failed</option>';
        return;
    }

    $sql = "SELECT * FROM violation";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<option disabled selected>Select Violation</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['ViolationID'] . '">' . htmlspecialchars($row['Violation']).'</option>';
        }
    } else {
        echo '<option disabled>No violations found</option>';
    }
}

function getSelectCourse()
{
    global $conn;

    $sql = "SELECT
                CourseID, 
                Course, 
                DepartmentID, 
                `Desc` AS Descript
            FROM
                course
            ORDER BY
                `Desc` ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<option value="" disabled selected>Select Course</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . (int)$row['CourseID'] . '">' . htmlspecialchars($row['Descript']) . '</option>';
        }
    } else {
        echo '<option disabled>No courses found</option>';
    }
}

function getSelectYear()
{
    global $conn;

    $sql = "SELECT * FROM yearlevel ORDER BY YearLevel ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<option value="" disabled selected>Select Year Level</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . (int)$row['YearLevelID'] . '">' . htmlspecialchars($row['YearLevel']) . '</option>';
        }
    } else {
        echo '<option disabled>No year levels found</option>';
    }
}


// Set Alert Message
function setAlertMessage($message, $color)
{
    $_SESSION['alert'] = '
    <div class="alert alert-' . $color . ' text-center mt-2 mb-2" role="alert">
      ' . $message . '
    </div>';
}

// Get Alert Message
function getAlertMessage()
{
    if (isset($_SESSION['alert'])) {
        $msg = $_SESSION['alert'];
        unset($_SESSION['alert']);
        return $msg;
    }
    return "";
}
?>