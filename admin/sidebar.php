  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      
<?php if($current_role=="admin"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-shop"></i><span>VENUE</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="venue_list.php">
              <i class="bi bi-circle"></i><span>Venue list</span>
            </a>
          </li>
          <li>
            <a href="block_list.php">
              <i class="bi bi-circle"></i><span>Block list</span>
            </a>
          </li>
          <li>
            <a href="venue.php">
              <i class="bi bi-circle"></i><span>add new venue</span>
            </a>
          </li>
          <li>
            <a href="block.php">
              <i class="bi bi-circle"></i><span>add new block</span>
            </a>
          </li>
          <li>
            <a href="rooms.php">
              <i class="bi bi-circle"></i><span>Available room</span>
            </a>
          </li>
          
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tags"></i><span>USERS COMMENTS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
          <li>
            <a href="comments.php">
              <i class="bi bi-circle"></i><span>view comment</span>
            </a>
          </li>
          <li>
            <a href="users_comment.php">
              <i class="bi bi-circle"></i><span>Generate a report</span>
            </a>
          </li>
         
        </ul>
      </li><!-- End Icons Nav --><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-shop"></i><span>DEPARTMENT</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="add_department.php">
              <i class="bi bi-circle"></i><span>New department</span>
            </a>
          </li>
          <li>
            <a href="department_list.php">
              <i class="bi bi-circle"></i><span>Department list</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people-fill"></i><span>USERS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="users_list.php">
              <i class="bi bi-circle"></i><span>users list</span>
            </a>
          </li>
          <li>
            <a href="add_user.php">
              <i class="bi bi-circle"></i><span>add new</span>
            </a>
          </li>
         
        </ul>
      </li><!-- End Components Nav -->
      <?php } ?>

     
<?php if($current_role== "CR"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-receipt-cutoff"></i><span>Booking</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="venue_list.php">
              <i class="bi bi-circle"></i><span>make booking</span>
            </a>
          </li>
          <li>
            <a href="my_bookings.php">
              <i class="bi bi-circle"></i><span>history</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Charts Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tags"></i><span>COMMENTS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
          <li>
            <a href="comment.php">
              <i class="bi bi-circle"></i><span>Leave comment</span>
            </a>
          </li>
          <li>
            <a href="comment_history.php">
              <i class="bi bi-circle"></i><span>Comment history</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-table"></i><span>TIME TABLE</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          
          <li>
            <a href="cr_file.php">
              <i class="bi bi-circle"></i><span>View time table</span>
            </a>
          </li>
        </ul>
    </li>
<?php } ?>
<?php if($current_role== "hod"){ ?>
  <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>CRS</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
      
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="CRS.php">
              <i class="bi bi-circle"></i><span>CRSL ist</span>
            </a>
          </li>
          <li>
            <a href="add_user.php">
              <i class="bi bi-circle"></i><span>add new</span>
            </a>
          </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-table"></i><span>TIME TABLE</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="timetable.php">
              <i class="bi bi-circle"></i><span>Upload time table</span>
            </a>
          </li>
          <li>
            <a href="files_list.php">
              <i class="bi bi-circle"></i><span>View time table</span>
            </a>
          </li>
        </ul>
    </li>
<?php } ?>


      
      
</ul>

  </aside><!-- End Sidebar-->

 