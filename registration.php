<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$sql = "SELECT * FROM registrations WHERE student_id = ".$_SESSION["usr_id"];
$result = $conn->query($sql);
if($result->num_rows > 0){
    $reg = 1;
} else {
    $reg = 0;
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Registration";
    getRegUnits(<?php echo "".$_SESSION["usr_id"]; ?>);
</script>

<?php
    if($reg == 0){
        echo "
        <div class=\"container\">
            <button class=\"btn btn-primary\" onclick='registerSem(".$_SESSION["usr_id"]."); log(\"action\", \"Register for semester units\", window.location.href);'>Register</button>
        </div>
    <br>
    
    <div class=\"container\">
        <h4>Units you will take if you register for this semester</h4>
    </div>
        ";
    } else {
        echo "
        <div class=\"container\">
            <h4>Units you are taking this semester</h4>
        </div>
        ";
    }
?>

<div class="container">
    <table class="table shadow">
        <thead class="thead-dark">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Year</th>
                <th>Semester</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody id="regT">

        </tbody>
    </table>
</div>

<?php
include("includes/footer.php");
?>