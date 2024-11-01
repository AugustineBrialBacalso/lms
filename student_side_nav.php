<div id="sidenav" class="sidenav">

<div class="bcplogo">
    <img src="img/bcplogo-mini.png" alt="img" class="bcplogo">
</div>

<div class="notif-btn">
        <i class="fa-regular fa-bell"></i>
</div>

<div class="user-btn" id="userBtn" aria-haspopup="true" aria-expanded="false">
    <i class="fa-regular fa-circle-user"></i>
    <!-- Profile Popup -->
<div class="profile-popup" id="profilePopup" role="menu" aria-hidden="true">
    <a href="profile-student.php" role="menuitem"><i class="fa-regular fa-user"></i> My Profile</a>
    <hr>
    <a href="logout.php" role="menuitem"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
</div>
</div>

<div class="avatar">
    <img src="img/avatar.jpeg" alt="avatar" class="avatar">
    <h5 class="username"><?php echo $_SESSION['name']; ?></h5>
</div>

<hr class="inline"></br>
<h5 class="admin-dashboard">STUDENT DASHBOARD</h5>
<div class="dashboard-container">

    <a class="menu" href="student.php"> 
    <h4 class="board-name"> <span class="dash-icon"><i class="fa-solid fa-border-all"></i></span> Dashboard</h4>  
    </a>
    
    <a class="menu" href="borrowed.php"> 
    <h4 class="board-name"> <span class="dash-icon"><i class="fa-solid fa-hand-holding"></i></span> Borrowed</h4>
    </a>

    <a class="menu" href="due.php"> 
    <h4 class="board-name"> <span class="dash-icon"><i class="fa-regular fa-calendar"></i></span> Due</h4>
    </a>

</div>
</div>