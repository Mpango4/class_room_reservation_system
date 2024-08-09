<?php
session_start();
include("header.php");
include("sidebar.php");

include("db_connection.php");

$user_id = $_SESSION['user_id'];

// Fetch uploaded files for the logged-in user
$stmt = $conn->prepare("SELECT id, title, original_file_name, file_path, file_type FROM uploaded_files WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

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
                        <div class="mb-3">
                            <a href="timetable.php" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload NEW
                            </a>
                        </div>
                        
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
                                            <a href="delete_file.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file?');">
                                                <i class="bi bi-trash"></i> Delete
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
$stmt->close();
$conn->close();
include("footer.php");
?>
