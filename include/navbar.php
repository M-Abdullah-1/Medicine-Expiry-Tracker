<div class="container-fluid bg-dark bgOpacity">
  <nav class="navbar navbar-expand-sm navbar-dark  bg-dark">
    <a href="#" class="navbar-brand text-light pointer">
      <i class="fas fa-clinic-medical"></i>
      <span>Medical Store</span>
    </a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a href="index.php" class="nav-link  text-light">View</a>
      </li>
      <li class="nav-item">
        <a href="sell.php" class="nav-link  text-light">Sell</a>
      </li>
      <li class="nav-item">
        <a href="record.php" class="nav-link  text-light">Record</a>
      </li>
      <?php
        if (isset($_SESSION['s_userId'])) {
          echo '
            <li class="nav-item">
              <a href="#" class="nav-link  text-light p-0">
                <span  class="d-block p-2" onclick="setting()">Setting</span>
              </a>
            </li>
          ';
          echo '
            <li class="nav-item">
              <a href="#" class="nav-link  text-light p-0">
                <span  class="d-block p-2" onclick="finance()">Finance</span>
              </a>
            </li>
          ';

        }
       ?>

      <li class="nav-item">
        <a href="expiry.php" class="nav-link  text-light">Expiry <sup class="badge badge-danger badge-pill"></sup></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <?php
        if (isset($_SESSION['s_userId'])) {
          // echo '<a id="navbarExpiryBtn" href="expiry.php" class="btn btn-outline-light mx-2">Expiry <sup id="expiryNo"></sup></a>';
          echo '<a href="#"  onclick="logout()" class="btn btn-secondary bg_transparent">Logout</a>';
        } else {
          // echo '<a id="navbarExpiryBtn" href="expiry.php" class="btn btn-outline-light mx-2">Expiry <sup id="expiryNo"></sup></a>';
          echo '<a href="#"  onclick="login()" class="btn btn-secondary">Login</a>';
        }
        ?>
        <!-- <input id="logInOut" type="button" class="btn btn-outline-light" value="Login" onclick="login()"> -->
      </li>
    </ul>
  </nav>
</div>
