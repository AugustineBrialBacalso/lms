<div class="bcplogo">
    <a href="index.php"><img src="img/bcplogo-mini.png" alt="img" class="bcplogo"></a>
</div>

<div class="notif-btn">
    <i class="fa-regular fa-bell"></i>
</div>

<div class="user-btn" id="userBtn" aria-haspopup="true" aria-expanded="false">
    <i class="fa-regular fa-circle-user"></i>

    <!-- Profile Popup -->
    <div class="profile-popup" id="profilePopup" role="menu" aria-hidden="true">
        <a href="profile.php" role="menuitem"><i class="fa-regular fa-user"></i> My Profile</a>
        <hr>
        <a href="logout.php" role="menuitem"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>

<div class="avatar">
    <img src="img/avatar.jpeg" alt="avatar" class="avatar">
    <h5 class="username"><?php echo $_SESSION['name']; ?></h5>
</div>

<hr class="inline"></br>
<h5 class="admin-dashboard">ADMIN DASHBOARD</h5>
<div class="dashboard-container">
    <a class="dashboard" href="index.php">
        <h4 class="board-name"> <span class="dash-icon"><i class="fa-solid fa-chart-pie"></i></span> Dashboard</h4>
    </a>

    <button class="drpdown-btn">
        <a class="drp-name"> <span class="book-icon"><i class="fa-solid fa-book"></i></span> Books</a>
        <i class="fa fa-caret-down"></i>
    </button>

    <div class="drpdown-container">
        <a class="drplink" href="list-of-books.php"><span class="drplink_name">List of Books</span></a>
        <a class="drplink" href="add-books.php"><span class="drplink_name">Add New Book</span></a>
    </div>

    <button class="drpdown-btn">
        <a class="transaction-name"> <span class="transaction-icon"><i class="fa-regular fa-folder-open"></i></span> Transaction</a>
        <i class="fa fa-caret-down"></i>
    </button>

    <div class="drpdown-container">
        <a class="drplink-trans" href="borrow-book.php"><span class="drplink_name">Borrow Book</span></a>
        <a class="drplink-trans" href="transaction-history.php"><span class="drplink_name">Transaction History</span></a>
    </div>
</div>