<?php
session_start();
include("header.php");
include("db_connection.php");

// Check if the user is logged in

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<?php include("sidebar.php"); ?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Comment and Recommendation</h5>
            <div id="message"></div>
            <form class="row g-3" id="commentForm" method="post">
                <div class="col-md-12">
                    <div class="form-floating">
                        <?php
                        // Fetch the user's first name from the users table
                        $sql = "SELECT firstname FROM users WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($row = $result->fetch_assoc()) {
                            $first_name = htmlspecialchars($row['firstname']);
                        } else {
                            $first_name = '';
                        }
                        
                        $stmt->close();
                        ?>
                        <input type="text" class="form-control" id="floatingName" placeholder="Your Name" value="<?php echo $first_name; ?>" readonly>
                        <label for="floatingName">Your Name<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="comment_description" placeholder="Comment description" id="floatingTextarea1" style="height: 100px;" required></textarea>
                        <label for="floatingTextarea1">Comment description <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="recommendation" placeholder="Your Recommendation" id="floatingTextarea2" style="height: 100px;"></textarea>
                        <label for="floatingTextarea2">Your Recommendation <span class="text-warning">(optional)</span></label>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'submit_comment.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#message').html(response);
                $('#message').fadeIn().delay(2000).fadeOut();
                $('#commentForm')[0].reset();
            },
            error: function(xhr, status, error) {
                $('#message').html('<div class="alert alert-danger">Error submitting comment: ' + error + '</div>');
                $('#message').fadeIn().delay(2000).fadeOut();
            }
        });
    });
});
</script>

<?php include("footer.php"); ?>
