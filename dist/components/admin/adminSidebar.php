<!--SideBar-->
<aside id="sidenav" class="sidebar">
    <ul class="menu-links menu-links-color">
    <span
        id="close-btn"
        href="javascript:void(0)"
        >&times;</span
    >
    <li>
        <a id="db" href="admin-dashboard.php"
        ><i class="fa fa-list-ul"></i>&nbsp;&nbsp;&nbsp;Dashboard</a
        >
    </li>
    <li>
        <a id="db" href="#"
        ><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Messages</a
        >
    </li>
    <li>
        <a id="add" href="admin-add-pets.php"
        ><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add Pets</a
        >
    </li>
    <li>
        <a id="manage" href="admin-manage-pets.php"
        ><i class="fa fa-paw"></i>&nbsp;&nbsp;&nbsp;Manage Pets</a
        >
    </li>
    <li>
        <a id="users" href="admin-manage-user.php"
        ><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Manage Users</a
        >
    </li>
    <li>
        <a id="add" href="admin-audit-trail.php">
        <i class="fa fa-clock-o"></i>
        &nbsp;&nbsp;&nbsp;Audit Trail</a>
    </li>
    <li>
        <a id="logout" href="javascript:void(0);" onclick="logout()"
        ><i class="fa fa-arrow-circle-right"></i
        >&nbsp;&nbsp;&nbsp;Logout</a
        >
    </li>
    </ul>
    <span
    id="menu-btn"
    style="font-size: 30px; cursor: pointer"
    >&#9776;</span
    >
</aside>

<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            // Perform logout action
            window.location.href = "../function/authentication/logout.php";
        }
    }
</script>