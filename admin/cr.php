<?php
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php"); // Include your database connection file

// Get the department of the logged-in HOD
$hod_department = $_SESSION['department'];

// Fetch users where role is "CR" and department matches the HOD's department
$sql = "SELECT * FROM users WHERE role = 'CR'";
$stmt = $conn->prepare($sql);
//$stmt->bind_param("s");
$stmt->execute();
$result = $stmt->get_result();
?>

<main id="main" class="main">
<div class="pagetitle">
  <h1>Users Data</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item">Users</li>
      <li class="breadcrumb-item active">Users List</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">CRS LIST</h5>
          
          <!-- Search field and Add New User button -->
          <div class="row mb-3">
            <div class="col-md-6">
              <input type="text" id="search" class="form-control" placeholder="Search by name, email, or phone">
            </div>
           
          </div>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th>Image</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>PhoneNumber</th>
                <th>Role</th>
                <th>Class</th>
               
              </tr>
            </thead>
            <tbody id="userTable">
              <?php if ($result->num_rows > 0) : ?>
                <?php while($row = $result->fetch_assoc()) : ?>
                  <tr>
                    <td><img src="<?php echo "uploads/".$row['image']; ?>" alt="User Image" style="width:50px; height:50px;"></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phonenumber']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['class']; ?></td>
                   
                  </tr>
                <?php endwhile; ?>
              <?php else : ?>
                <tr><td colspan="9">No users found</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

<?php include("footer.php"); ?>
<script>
document.getElementById('search').addEventListener('input', function() {
    var filter = this.value.toUpperCase();
    var rows = document.querySelector("#userTable").rows;
    
    for (var i = 0; i < rows.length; i++) {
        var firstName = rows[i].cells[1].textContent.toUpperCase();
        var lastName = rows[i].cells[2].textContent.toUpperCase();
        var email = rows[i].cells[3].textContent.toUpperCase();
        var phoneNumber = rows[i].cells[4].textContent.toUpperCase();
        
        if (firstName.indexOf(filter) > -1 || lastName.indexOf(filter) > -1 || email.indexOf(filter) > -1 || phoneNumber.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
});
</script>
