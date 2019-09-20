<?php
session_start();
include("includes/header.php");
include("controllers/db.php");
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "User Logs";
</script>

<?php
include("includes/footer.php");
?>