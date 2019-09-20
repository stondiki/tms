<?php
session_start();
include("includes/header.php");
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Login";
</script>

<div id="form-container" class="shadow">
    <form id="frm" action="controllers/login.php" method="post">
        <h1>Login</h1>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary btn-block" onclick="log('action', 'Submit login credentials', window.location.href);">Login</button>
    </form>
</div>

<?php
include("includes/footer.php");
?>