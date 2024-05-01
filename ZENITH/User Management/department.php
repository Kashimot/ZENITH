<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
$is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 0;

// If the user is an admin, redirect to the admin dashboard
if ($is_admin == 1) {
    header("Location: admin_dashboard.php");
    exit();
}

// Non-admin user, redirect to the assigned department
if (isset($_SESSION['department'])) {
    // Get the assigned department from the session
    $department = strtolower($_SESSION['department']);

    // Redirect to the corresponding department page
    switch ($department) {
        case 'facilities management':
            header("Location: facilities_management.php");
            exit();
        case 'operations':
            header("Location: operations_department.php");
            exit();
        case 'training':
            header("Location: training_department.php");
            exit();
        case 'supply':
            header("Location: supply_department.php");
            exit();
        default:
            // Handle unknown department
            header("Location: default_department.php");
            exit();
    }
} else {
    // No department assigned, redirect to a default page
    header("Location: default_department.php");
    exit();
}
?>
