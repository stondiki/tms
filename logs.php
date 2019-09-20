<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$sql = "SELECT COUNT(*) AS c FROM system_log";
$result = $conn->query($sql);
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        $r = $row["c"];
    }
}

$pages = ceil($r / 20);
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Logs";
    let pages = <?php echo $pages; ?>;
</script>

<div class="container2">
    <div style="width:150px;">
        <label for="filter">Filter by:</label>
        <select name="filter" class="form-control" id="filter" onchange="getLogOptions(this.value)">
            <option value="none"> </option>
            <option value="username">Username</option>
            <option value="event">Event</option>
            <option value="ip">IP Address</option>
        </select>
        <select name="selected" id="selected" class="form-control" onchange="setAndGet()">

        </select>
    </div>
</div>

<div class="container2">
    <div style="width:100px;">
        <label for="page">Page</label>
        <select name="page" id="page" class="form-control" onchange="getLogs()">

        </select>
    </div>
</div>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Event</th>
                <th>Element clicked</th>
                <th>Page</th>
                <th>IP Address</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody id="log-table">

        </tbody>
    </table>
</div>

<script>
    let pageCon = document.getElementById("page");
    for(x=0; x<pages; x++){
        pageCon.innerHTML += `
            <option value="`+(x+1)+`">`+(x+1)+`</option>
        `;
    }
    getLogs();
</script>

<?php
include("includes/footer.php");
?>