<?php
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php");

?>

<main id="main" class="main">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">COMMENT AND RECOMMENDATIONS REPORT</div>
            <div class="card-body">
                <h5 class="card-title">Comments and Recommendations</h5>
                <?php
                $sql = "SELECT users.firstname, comments.comment_description, comments.recommendation 
                        FROM comments 
                        INNER JOIN users ON comments.user_id = users.id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th>Name</th><th>Comment</th><th>Recommendation</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['comment_description']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['recommendation']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>No comments and recommendations found.</p>';
                }
                ?>
                <form action="generate_pdf.php" method="post">
                    <button type="submit" class="btn btn-primary">Generate PDF</button>
                </form>
            </div>
            <div class="card-footer">
               &COPY; DIT Class room reservation system
            </div>
        </div><!-- End Card with header and footer -->
    </div>
</main>

<?php include("footer.php"); ?>
