<?php
    include("./Handler.php");
    session_start();
    $count = 0;
    if(isset($_SESSION["count"])) {
        $count = $_SESSION["count"];
    }else{
        $_SESSION["count"] = $count;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="get" action="./sessionCounter.php">
        <button type="submit">
            Counted <?php
                echo $count
            ?>
            <?php
                if($count <= 1){
                    echo "time";
                }else{
                    echo "times";
                }
            ?>
        </button>
    </form>
    <form method="get" action="./resetSession.php">
        <button type="submit">
            Reset
        </button>
    </form>
</body>
</html>