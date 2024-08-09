<?php
session_start();
include("header.php");
include("sidebar.php");

?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Upload Time Table</h5>

            <?php
            // Display response messages
            if (isset($_SESSION['response_message'])) {
                echo '<div class="alert ' . $_SESSION['response_message']['type'] . '">' . $_SESSION['response_message']['message'] . '</div>';
                unset($_SESSION['response_message']);
            }
            ?>

            <!-- Multi Columns Form -->
            <form class="row g-3" action="upload_file.php" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="col-8">
                    <label for="file" class="form-label">Choose a File</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls, .pdf" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</main>

<?php include("footer.php");?>
