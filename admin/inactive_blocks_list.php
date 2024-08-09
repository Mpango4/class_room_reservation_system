<?php
session_start();
include("db_connection.php");

// Handle the search query
$search = "";
$search_query = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search_query = "WHERE block_name LIKE '%$search%' OR description LIKE '%$search%'";
}

$sql = "SELECT id, block_name, description, status FROM blocks $search_query where status='inactive'";
$result = $conn->query($sql);
?>

<?php include("header.php");?>
<?php include("sidebar.php");?>

<main id="main" class="main">
<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Registered Blocks <span>| All</span></h5>

            <!-- Search Form -->
            <form action="venue.php" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for blocks" name="search">
                </div>
            </form>

            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Block Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status_class = ($row['status'] == 'active') ? 'btn-success' : 'btn-danger';
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['id'] . "</th>";
                            echo "<td>" . $row['block_name'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>
                                    <button type='button' class='btn btn-status $status_class' data-id='" . $row['id'] . "' data-status='" . $row['status'] . "'>" . ucfirst($row['status']) . "</button>
                                  </td>";
                            echo "<td>
                                    <button type='button' class='btn btn-secondary btn-edit' data-id='" . $row['id'] . "' data-name='" . $row['block_name'] . "' data-description='" . $row['description'] . "'><i class='bi bi-pencil-square'></i></button>
                                    <button type='button' class='btn btn-danger btn-delete' data-id='" . $row['id'] . "'><i class='bi bi-trash'></i></button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No inactive blocks registered</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- End Recent Sales -->
</main>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Block</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editBlockName" class="form-label">Block Name</label>
                        <input type="text" class="form-control" id="editBlockName" name="block_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to filter table rows based on user input
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementsByName("search")[0];
        filter = input.value.toUpperCase();
        table = document.querySelector(".datatable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    document.getElementsByName("search")[0].addEventListener("input", filterTable);

    // Handle status change
    document.querySelectorAll('.btn-status').forEach(button => {
        button.addEventListener('click', function() {
            var blockId = this.getAttribute('data-id');
            var currentStatus = this.getAttribute('data-status');
            var newStatus = (currentStatus === 'active') ? 'inactive' : 'active';
            var button = this;

            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${blockId}&status=${newStatus}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    button.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    button.setAttribute('data-status', newStatus);
                    button.classList.toggle('btn-success', newStatus === 'active');
                    button.classList.toggle('btn-danger', newStatus === 'inactive');
                } else {
                    alert('Failed to update status');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Handle edit button click
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            var blockId = this.getAttribute('data-id');
            var blockName = this.getAttribute('data-name');
            var blockDescription = this.getAttribute('data-description');
            
            document.getElementById('editId').value = blockId;
            document.getElementById('editBlockName').value = blockName;
            document.getElementById('editDescription').value = blockDescription;
            
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });

    // Handle edit form submission
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);

        fetch('update_block.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                location.reload();
            } else {
                alert('Failed to update block');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Handle delete button click
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            var blockId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this block?')) {
                fetch('delete_block.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${blockId}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to delete block');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});
</script>

<?php include("footer.php");?>
