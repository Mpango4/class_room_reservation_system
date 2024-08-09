
<?php
session_start();
include("db_connection.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $block_name = $_POST['block_name'];
    $description = $_POST['description'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO blocks (block_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $block_name, $description);

    if ($stmt->execute()) {
        // Success message
        $message = "<div class='alert alert-success fade-out'>New block registered successfully</div>";
    } else {
        // Error message
        $message = "<div class='alert alert-danger fade-out'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();

    // Redirect to the same page to prevent form resubmission
    header("Location: block.php?message=" . urlencode($message));
    exit();
}

// Retrieve the message if redirected
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
}
?>

<?php
include("header.php");?>
<?php
include("sidebar.php");?>
    <style>
        .fade-out {
            opacity: 1;
            transition: opacity 2s ease-out;
        }

        .fade-out.hidden {
            opacity: 0;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.add('hidden');
                    setTimeout(function() {
                        alert.remove();
                    }, 2000); // 2 seconds for fade out transition
                }
            }, 3000); // 3 seconds before starting fade out
        });
    </script>
<main id="main" class="main">
<div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Block</h5>
              
                    <?php echo $message; ?>
         
                <form class="row g-3" action="block.php" method="POST">
            <div class="form-group">
                <label for="block_name">Block Name:</label>
                <input type="text" class="form-control" id="block_name" name="block_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" style="height: 100px" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
        </div>
  </div>
</main>

<?php include("footer.php");?>