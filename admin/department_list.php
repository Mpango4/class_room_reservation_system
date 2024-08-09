<?php
session_start();
include("header.php");
include("sidebar.php");

// Include your database connection file
include("db_connection.php");

// Initialize variables
$search = "";
$search_query = "";

// Check if the search query is set
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // SQL query to search for departments based on name or description
    $search_query = "WHERE department_name LIKE '%$search%' OR description LIKE '%$search%'";
}

// SQL query to fetch departments from the database
$sql = "SELECT * FROM departments $search_query";
$result = $conn->query($sql);
?>

<main id="main" class="main">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List of Departments</h5>

                <!-- Search Form -->
                <form action="" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for departments" name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                <!-- Table with stripped rows -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col" colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['id'] . "</th>";
                                echo "<td>" . $row['department_name'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td><button type='button' class='btn btn-secondary' onclick='editDepartment(" . $row['id'] . ")'><i class='bi bi-pencil-square'></i></button></td>";
                                echo "<td><button type='button' class='btn btn-success' onclick='viewDepartment(" . $row['id'] . ")'><i class='bi bi-eye-fill'></i></button></td>";
                                echo "<td><button type='button' class='btn btn-danger' onclick='deleteDepartment(" . $row['id'] . ")'><i class='bi bi-trash'></i></button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No departments found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Edit Department Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Edit Department</h2>
        <form id="editForm">
            <input type="hidden" id="editId" name="id">
            <div class="mb-3">
                <label for="editDepartmentName" class="form-label">Department Name</label>
                <input type="text" class="form-control" id="editDepartmentName" name="department_name" required>
            </div>
            <div class="mb-3">
                <label for="editDescription" class="form-label">Description</label>
                <textarea class="form-control" id="editDescription" name="description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<!-- View Department Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('viewModal')">&times;</span>
        <h2>View Department</h2>
        <div id="viewDetails"></div>
    </div>
</div>

<!-- JavaScript for modal handling -->
<script>
    function editDepartment(id) {
        fetch(`fetch_department.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editId').value = data.id;
                document.getElementById('editDepartmentName').value = data.department_name;
                document.getElementById('editDescription').value = data.description;
                document.getElementById('editModal').style.display = 'block';
            });
    }

    function viewDepartment(id) {
        fetch(`fetch_department.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('viewDetails').innerHTML = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Name:</strong> ${data.department_name}</p>
                    <p><strong>Description:</strong> ${data.description}</p>
                `;
                document.getElementById('viewModal').style.display = 'block';
            });
    }

    function deleteDepartment(id) {
        if (confirm('Are you sure you want to delete this department?')) {
            fetch(`delete_department.php?id=${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting department');
                    }
                });
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('edit_department.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal('editModal');
                location.reload();
            } else {
                alert('Error updating department');
            }
        });
    });
</script>

<!-- CSS for modals -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000; /* Ensure the modal is above other content */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px; /* Ensure the modal is not too wide */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<?php include("footer.php"); ?>
