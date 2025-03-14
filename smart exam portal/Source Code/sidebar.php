<?php 

include('connect.php');

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    die("Error: User is not logged in.");
}

// Fetch admin details
$sql = "SELECT * FROM admin WHERE id = '" . $_SESSION["id"] . "'";
$result = $conn->query($sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Error: No data found for the given ID");
}

$row1 = mysqli_fetch_array($result);

// Fetch permissions based on role
$q = "SELECT * FROM tbl_permission_role WHERE role_id='" . $row1['group_id'] . "'";
$ress = $conn->query($q);

if (!$ress) {
    die("Error: Failed to fetch permissions.");
}

$name = array();
while ($row = mysqli_fetch_array($ress)) {
    $perm_query = "SELECT * FROM tbl_permission WHERE id = '" . $row['permission_id'] . "'";
    $perm_result = $conn->query($perm_query);
    
    if ($perm_result) {
        $row_perm = mysqli_fetch_array($perm_result);
        if ($row_perm) {
            array_push($name, $row_perm[1]);
        }
    }
}

$_SESSION['name'] = $name;
$useroles = $_SESSION['name'];
?>

<div class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li> <a href="index.php" aria-expanded="false"><i class="fa fa-window-maximize"></i>Dashboard</a></li>

                <!-- Check user permissions before showing menu -->
                <?php if (isset($useroles) && in_array("manage_attendence", $useroles)) { ?> 
                <li> 
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-clock-o"></i><span class="hide-menu">Attendance Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (in_array("add_attendence", $useroles)) { ?> 
                            <li><a href="add_attendence.php">Add Attendance</a></li>
                        <?php } ?>
                        <li><a href="view_attendence.php">View Attendance</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (isset($useroles) && in_array("manage_teacher", $useroles)) { ?> 
                <li> 
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-user"></i><span class="hide-menu">Teacher Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (in_array("add_teacher", $useroles)) { ?> 
                            <li><a href="add_teacher.php">Add Teacher</a></li>
                        <?php } ?>
                        <li><a href="view_teacher.php">View Teacher</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (isset($useroles) && in_array("manage_student", $useroles)) { ?> 
                <li> 
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-users"></i><span class="hide-menu">Student Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (in_array("add_student", $useroles)) { ?> 
                            <li><a href="add_student.php">Add Student</a></li>
                        <?php } ?>
                        <li><a href="view_student.php">View Student</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (isset($useroles) && in_array("manage_exam", $useroles)) { ?> 
                <li> 
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-home"></i><span class="hide-menu">Exam Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse"> 
                        <li><a href="add_roomtype.php">Add Room Type</a></li>
                        <li><a href="view_roomtype.php">View Room Type</a></li>
                        <li><a href="add_room.php">Add Room</a></li>
                        <li><a href="view_room.php">View Room</a></li>
                        <li><a href="add_exam.php">Add Exam</a></li>
                        <li><a href="view_exam.php">View Exam</a></li>
                        <li><a href="add_allotment.php">Add Allotment</a></li>
                        <li><a href="view_allotment.php">View Allotment</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (isset($_SESSION["username"]) && $_SESSION["username"] == 'admin') { ?>
                <li> 
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-lock"></i><span class="hide-menu">User Permissions</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="assign_role.php">Assign Role</a></li>
                        <li><a href="view_role.php">View Role</a></li>
                    </ul>
                </li>
                <li> 
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-cog"></i><span class="hide-menu">Settings</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="manage_website.php">Appearance Management</a></li>
                        <li><a href="email_config.php">Email Management</a></li>
                    </ul>
                </li>
                <li class="nav-label">Reports</li> 
                <li>  
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-file"></i><span class="hide-menu">Report Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="today_exam.php">Today's Exam</a></li>
                        <li><a href="report_exam.php">Exam Report</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>   
        </nav>
    </div>
</div>
