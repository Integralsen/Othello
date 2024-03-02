<html>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="css/sample.css">
<title>オセロ</title>
</head>
<body>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/osero.js"></script>
<form method="GET" action="sample.php">
    <div id="sample">
    <input type="radio" id="select" name="select" value="0" checked>手動
    <input type="radio" id="select" name="select" value="1" <?php if(isset($_GET['select']) && $_GET['select'] == 1) echo 'checked' ?>>CPU<br>
    <span id="sample2">
    <input type="radio" id="select2" name="select2" value="0" checked>先攻
    <input type="radio" id="select2" name="select2" value="1" <?php if(isset($_GET['select2']) && $_GET['select2'] == 1) echo'checked' ?>>後攻
    </span>
    <input type="submit" id="submit" value="決定">
    <?php
    /**
    if($_GET['select'] == 0){
        echo '<input type="button" id="pass" value="パス">';
    }
    */
    ?>
    <span id="text"></span>
    <span id="text2"></span>
    </div>
</form>
<?php
require_once('osero.php');
$field[][] = "";
$result[][] = "";
$num = 0;
$osero = new Osero();
$flag = true;
for($i=0; $i<8; $i++){
    for($j=0; $j<8; $j++){
        $result[$i][$j] = $osero->getValue($i, $j);
        if(!isset($_GET['select'])){
            $field[$i][$j] = '<button type="submit" id="button'.$num.'" onclick=player('.$num.');>'.$result[$i][$j].'</button>';
            echo $field[$i][$j];
            $num++;
        }else{
            if($_GET['select'] == 0){
                $field[$i][$j] = '<button type="submit" id="button'.$num.'" onclick=player('.$num.');>'.$result[$i][$j].'</button>';
            }else{
                $field[$i][$j] = '<button type="submit" id="button'.$num.'" onclick=player2('.$num.');>'.$result[$i][$j].'</button>';
            }
            echo $field[$i][$j];
            $num++;
        }
    }
    echo "<br>";
}
?>
</body>
</html>
