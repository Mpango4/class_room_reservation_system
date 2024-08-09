<?php
session_start();
include("header.php");
include("sidebar.php");

// Include your database connection file
include("db_connection.php");

// SQL query to fetch comments along with the class from the users table
$sql = "SELECT comments.id, users.class, comments.comment_description, comments.recommendation 
        FROM comments 
        JOIN users ON comments.user_id = users.id";
$result = $conn->query($sql);
?>

<main id="main" class="main">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List of Comments</h5>
                <form action="generate_new.php" method="post">
                    <button type="submit" class="btn btn-primary">Generate PDF</button>
                </form>
                <!-- Table with stripped rows -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Class</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Recommendation</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['id'] . "</th>";
                                echo "<td>" . htmlspecialchars($row['class']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['comment_description']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['recommendation']) . "</td>";
                                echo "<td><button type='button' class='btn btn-danger' onclick='deleteComment(" . $row['id'] . ")'><i class='bi bi-trash'></i> Delete</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No comments found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript for deleting comment -->
<script>
    function deleteComment(id) {
        if (confirm('Are you sure you want to delete this comment?')) {
            fetch(`delete_comment.php?id=${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting comment');
                    }
                });
        }
    }
</script>

<?php include("footer.php"); ?>
