<?php
session_start();
include("includes/header.php");
include("controllers/db.php");
if(isset($_SESSION["usr_id"])){
    if($_SESSION["role"] == "student"){
        $sql = "SELECT * FROM faqs WHERE user_type = '1' OR user_type = '4' OR user_type = '5' OR user_type = '7' OR user_type = '8'";
        $result = $conn->query($sql);
        $faqs = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $f = array(
                    'id' => $row["id"],
                    'question' => $row["question"],
                    'answer' => $row["answer"]
                );
                array_push($faqs, $f);
            }
        }
    } else if($_SESSION["role"] == "lecturer"){
        $sql = "SELECT * FROM faqs WHERE user_type = '2' OR user_type = '4' OR user_type = '6' OR user_type = '7'OR user_type = '8'";
        $result = $conn->query($sql);
        $faqs = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $f = array(
                    'id' => $row["id"],
                    'question' => $row["question"],
                    'answer' => $row["answer"]
                );
                array_push($faqs, $f);
            }
        }
    } else if($_SESSION["role"] == "staff"){
        $sql = "SELECT * FROM faqs WHERE user_type = '3' OR user_type = '5' OR user_type = '6' OR user_type = '7' OR user_type = '8'";
        $result = $conn->query($sql);
        $faqs = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $f = array(
                    'id' => $row["id"],
                    'question' => $row["question"],
                    'answer' => $row["answer"]
                );
                array_push($faqs, $f);
            }
        }
    }
} else {
    $sql = "SELECT * FROM faqs WHERE user_type = '0' OR user_type = '8'";
    $result = $conn->query($sql);
    $faqs = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $f = array(
                'id' => $row["id"],
                'question' => $row["question"],
                'answer' => $row["answer"]
            );
            array_push($faqs, $f);
        }
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "FAQs";
</script>

<div class="container">
    <ul>
        <?php
            foreach($faqs as $x => $x_value){
                echo "
                    <li>
                        <div class=\"f-container shadow\">
                            <div class=\"question\" onclick=\"showAnswer('a".$x."')\">
                                <h3>Q. ".$x_value["question"]."</h3>
                            </div>
                            <div class=\"answer hide\" id=\"a".$x."\">
                                <p><b>A.</b> ".$x_value["answer"]."</p>
                            </div>
                        </div>
                    </li>
                ";
            }
        ?>
    </ul>
</div>

<?php
include("includes/footer.php");
?>