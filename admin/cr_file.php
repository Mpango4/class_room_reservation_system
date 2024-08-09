<?php
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php");

$department = $_SESSION['department'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch user IDs of users in the same department
$user_ids = [];
$stmt = $conn->prepare("SELECT id FROM users WHERE department = ?");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $user_ids[] = $row['id'];
}
$stmt->close();

if (empty($user_ids)) {
    echo "No users found in the department.";
    exit();
}

// Convert the user IDs to a comma-separated string
$user_ids_str = implode(',', $user_ids);

// Fetch uploaded files for the users in the same department
$query = "
    SELECT id, title, original_file_name, file_path, file_type 
    FROM uploaded_files 
    WHERE user_id IN ($user_ids_str)
";
$result = $conn->query($query);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Uploaded Files</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">TIME TABLE</h5>
                        
                        <!-- Upload New File Button -->
                       
                        
                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">File Name</th>
                                    <th scope="col">File Type</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['original_file_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['file_type']); ?></td>
                                        <td>
                                            <a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn btn-success btn-sm">
                                                <i class="bi bi-eye-fill"></i> View
                                            </a>
                                           
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
$conn->close();
include("footer.php");
?>
