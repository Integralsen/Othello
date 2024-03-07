<html>
    <head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="css/sample.css">
        <title>オセロ</title>
    </head>
    <body>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/othello.js"></script>
        <form method="GET" action="sample.php">
            <div id="sample">
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" role="switch" id="assist" name="assist" <?php if(isset($_GET['assist'])) echo 'checked' ?>>アシスト
                </div>
                <div class="form-check-inline">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="select" name="select" value="0" checked>手動
                    </div>
                </div>
                <div class="form-check-inline">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="select" name="select" value="1" <?php if(isset($_GET['select']) && $_GET['select'] == 1) echo 'checked' ?>>CPU
                    </div>
                </div>
                <br>
                <span id="sample2">
                    <div class="form-check-inline">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="select2" name="select2" value="0" checked>先攻
                        </div>
                    </div>
                    <div class="form-check-inline">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="select2" name="select2" value="1" <?php if(isset($_GET['select2']) && $_GET['select2'] == 1) echo'checked' ?>>後攻
                        </div>
                    </div>
                </span>
                <input type="submit" class="btn btn-outline-primary" id="submit" value="決定">
                <?php
                /**
                //意図的に「パス」する場合はコメントアウトを外す
                if(!isset($_GET['select']) || $_GET['select'] == 0){
                    echo '<input type="button" class="btn btn-outline-primary" id="pass" value="パス">';
                }
                */
                ?>
                <span id="text"></span>
                <span id="text2"></span>
            </div>
        </form>
        <?php
        require_once('othello.php');
        $field[][] = "";
        $result[][] = "";
        $num = 0;
        $othello = new Othello();
        //初期盤面のボタンを生成
        for($i=0; $i<8; $i++){
            for($j=0; $j<8; $j++){
                $result[$i][$j] = $othello->getValue($i, $j);
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
