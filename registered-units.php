<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$sem = "";
$drop = "no";
$getSem = "SELECT * FROM semesters WHERE active = 'yes'";
$getSemRes = $conn->query($getSem);
if($getSemRes->num_rows == 1){
    while($res = $getSemRes->fetch_assoc()){
        $sem = $res["id"];
        if($res["registration"] == 'yes'){
            $drop = "yes";
        }
    }
}

$units = array();
$sql = "SELECT * FROM registrations, units WHERE units.id = registrations.unit_id AND registrations.student_id = ".$_SESSION["usr_id"]." AND registrations.semester_id = ".$sem;
$result = $conn->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $u = array(
            'id' => $row["id"],
            'code' => $row["unit_code"],
            'name' => $row["unit_name"]
        );
        array_push($units, $u);
    }
} else {
    $resp = array(
        'status' => 'Error',
        'message' => 'No results.'
    );
    //echo json_encode($resp);
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Registered Units";
</script>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Actions</th>
                <th>Unit Code</th>
                <th>Unit Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if($drop == "yes"){
                    foreach($units as $x => $x_value){
                        echo "<tr>
                            <td>
                                <button class=\"btn btn-outline-danger\" onclick=\"dropUnit(".$x_value["id"].", ".$_SESSION["usr_id"].", ".$sem."); log('action', 'Drop unit ".$x_value["name"]."', window.location.href);\">
                                    <i class=\"fas fa-trash\"></i>
                                </button>
                            </td>
                            <td>".$x_value["code"]."</td>
                            <td>".$x_value["name"]."</td>
                        </tr>
                        ";
                    }
                } else {
                    foreach($units as $x => $x_value){
                        echo "<tr>
                            <td></td>
                            <td>".$x_value["code"]."</td>
                            <td>".$x_value["name"]."</td>
                        </tr>
                        ";
                    }
                }   
            ?>
        </tbody>
    </table>
</div>

<?php
include("includes/footer.php");
?>