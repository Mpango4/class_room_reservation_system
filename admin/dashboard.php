
<?php
session_start();
include("header.php");
?>
<?php
include("sidebar.php");
include("functions.php");
$hod_department = isset($_SESSION['department']) ? $_SESSION['department'] : '';
$recent_venues = getRecentVenues($conn);
// Count users with role 'CR' in the HOD's department
$cr_count = countUsersByRoleAndDepartment($conn, 'CR', $hod_department);
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
          <?php if($current_role=='admin'){ ?>
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                      <h6>Total Venue</h6>
                    </li>
                    <li><a class="dropdown-item" href="rooms.php">view</a></li>
                    
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total <span>| Venues</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-shop"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_venues; ?></h6>
                     

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            <?php } ?>
            <?php if($current_role=='hod'){ ?>
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                      <h6>Total CRS</h6>
                    </li>
                    <li><a class="dropdown-item" href="CRS.php">view</a></li>
                    
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total <span>| CRS</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $cr_count; ?></h6>
                     

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            <?php } ?>
            <?php if($current_role=='admin') { ?>
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                      <h6>Total users</h6>
                    </li>
                    <li><a class="dropdown-item" href="users_list.php">view</a></li>
                    
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total <span>| users</span></h5>
                  
                  <a href="users_list.php" style="text-decoration: none; color: inherit;">
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people-fill"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo $total_users; ?></h6>
                          </div>
                      </div>
                  </a>
              </div>

              </div>
            </div><!-- End Sales Card -->
            <?php } ?>
            <?php if($current_role=='admin') { ?>
            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Total Block</h6>
                    </li>

                    <li><a class="dropdown-item" href="block_list.php">View</a></li>
                   
                  </ul>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Total <span>| blocks</span></h5>

                    <a href="block_list.php" style="text-decoration: none; color: inherit;">
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?php echo $total_blocks; ?></h6>
                            </div>
                        </div>
                    </a>
                </div>

              </div>
            </div><!-- End Revenue Card -->
            <?php } ?>
            
            <!-- Customers Card -->
            <?php if($current_role=='admin'){?>
            <div class="col-xxl-4 col-xl-6">

              <div class="card info-card customers-card">

               

                <div class="card-body">
                  <h5 class="card-title">TATAL <span>| INACTIVE VENUE</span>
                
                </h5>
                
                  <a href="inactive_venues_list.php" style="text-decoration: none; color: inherit;">
                
                 
                    <a href="venue_list.php" style="text-decoration: none; color: inherit;">
                   
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-shop"></i>
                    </div>
                    <div class="ps-3">
                      
                        <h6><?php echo $total_inactive_venues; ?></h6>
                     
                    </div>
                  </div>
                  </a>
                </div>
              </div>

            </div><!-- End Customers Card -->
            <?php }?>

            <?php if($current_role=='CR'){?>
           
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                      <h6>Total CRS</h6>
                    </li>
                    <li><a class="dropdown-item" href="cr.php">view</a></li>
                    
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total <span>| CRS</span></h5>
                  
                  <a href="cr.php" style="text-decoration: none; color: inherit;">
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people-fill"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo $total_crs; ?></h6>
                          </div>
                      </div>
                  </a>
              </div>

              </div>
            </div>
            <!--END-->
            <div class="col-xxl-4 col-xl-4">

              <div class="card info-card customers-card">

               

                <div class="card-body">
                  
                <h5 class="card-title">TATAL <span>| AVAILABLE VENUE</span>
                </h5>
              
                  
                    <a href="venue_list.php" style="text-decoration: none; color: inherit;">
                   
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-shop"></i>
                    </div>
                    <div class="ps-3">
                     
                      
                        <h6><?php echo $active; ?></h6>
                        
                      
                    </div>
                  </div>
                  </a>
                </div>
              </div>

            </div><!-- End Customers Card -->
            <?php }?>
           
            <?php if($current_role== "admin"){?>
            <div class="col-xxl-4 col-xl-6">

              <div class="card info-card customers-card">

               
                
                <div class="card-body">
                  <h5 class="card-title">TATAL <span>| INACTIVE BLOCK</span></h5>
                  <a href="inactive_blocks_list.php" style="text-decoration: none; color: inherit;">
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $total_inactive_blocks; ?></h6>
                     

                    </div>
                  </div>
                  </a>
                </div>
                <?php }?>
                
                <?php if($current_role== "CR"){?>

                  <div class="col-xxl-4 col-xl-4">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">TATAL <span>| AVAILABLE BLOCKS</span></h5>
                  <a href="active_blocks_list.php" style="text-decoration: none; color: inherit;">
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $active_block; ?></h6>
                     

                    </div>
                  </div>
                  </a>
                </div>
               
              </div>

            </div><!-- End Customers Card -->
            <?php }?>

            <?php if($current_role== "CR"){  ?>
 <!-- Right side columns -->
 
    <div class="col-lg-4">
      <!-- Recent Activity -->
      <div class="card">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>View more..</h6>
            </li>
            <li><a class="dropdown-item" href="venue_list.php">view more..</a></li>
           >
          </ul>
        </div>

        <div class="card-body">
          <h5 class="card-title">New venue <span>| Last 7 days</span></h5>

          <div class="activity">
            <?php if (count($recent_venues) > 0): ?>
              <?php foreach ($recent_venues as $venue): ?>
                <div class="activity-item d-flex">
                  <div class="activite-label"><?php echo date('d M', strtotime($venue['created_at'])); ?></div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    <a href="view_venue.php?id=<?php echo $venue['id']; ?>" class="fw-bold text-dark">
                      <?php echo htmlspecialchars($venue['room_number']); ?>
                    </a>
                  </div>
                </div><!-- End activity item-->
              <?php endforeach; ?>
            <?php else: ?>
              <p>No recent venues registered.</p>
            <?php endif; ?>
          </div>

        </div>
      </div><!-- End Recent Activity -->
    </div>
  
  <?PHP } ?>
               
          <?php  if($current_role=="CR") {?>
           <?php include("history.php");?>
           <?php }?>
          </div>
        </div><!-- End Left side columns -->

       

      </div>
    </section>

  </main><!-- End #main -->
<?php include("footer.php");?>