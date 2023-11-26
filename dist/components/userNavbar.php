<link rel="stylesheet" href="../css/componentStyle/userNavbar.css">
<link
rel="stylesheet"
href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"
/>
<nav class="navbar">
  <a href="index.php" class="logo">
    <img src="../icons/logo.png" alt="Logo" />
  </a>

  <ul class="menu-links">
    <li><a href="home.php">Home</a></li>
    <li>
      <a href="adoptpage.php">
        Adopt
      </a>
    </li>
    <li><a href="donatepage.php" >Donate</a></li>
    <li><a href="volunteer.php" >Volunteer</a></li>
    <li class="language-item">
      <div class="dropdown">
        <label for="languageDropdown" class="dropdown-btn">
          <span class="material-symbols-outlined">language</span>
          English
        </label>
        <input type="checkbox" id="languageDropdown" />
        <div class="dropdown-content">
          <label for="English">
            English
            <input type="radio" name="language" id="English" data-language="en">
          </label>
          <label for="Spanish">
            Spanish
            <input type="radio" name="language" id="Spanish" data-language="es">
          </label>
          <label for="Filipino">
            Filipino
            <input type="radio" name="language" id="Filipino" data-language="fn">
          </label>
        </div>
      </div>
    </li>
    <?php
    if(session_status() == PHP_SESSION_NONE){
      // session has not started
      session_start();
    }
    if (isset($_SESSION['auth']) && $_SESSION['auth']) {
    ?>
    <li class="profile-item">
      <div class="dropdown">
        <label for="profileDropdown" class="dropdown-btn">
          <img class="icon-user" src="../icons/icons-user.png" alt="User Icon">
        </label>
        <input type="checkbox" id="profileDropdown" />
        <div class="dropdown-content">
          <label>
            <a href="edit-profile.php">Profile</a>
          </label>
          <label>
            <a href="../function/logout.php">Logout</a>
          </label>
        </div>
      </div>
    </li>
    <?php
      } else {
    ?>
        <li class="join-btn"><a href="../signuppage.php">Join Us</a></li>
    <?php
      }
    ?>
    <span id="close-menu-btn" class="material-symbols-outlined">close</span>
  </ul>
  <span id="hamburger-btn" class="material-symbols-outlined">menu</span>
</nav>

<script src="..\script\detect-page.js"></script>
<script src="..\script\user-navbar-change.js"></script>
<script type="module" src="..\script\translation.js"></script>

