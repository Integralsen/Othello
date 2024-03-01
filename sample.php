<html>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="css/sample.css">
<title>オセロ</title>
</head>
<body>
<script src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
var hantei1 = [28, 35];
var hantei2 = [27, 36];
var count = 0;

window.onload = () => {
    if(parseInt(<?= $_GET['select'] ?>) == 1 && parseInt(<?= $_GET['select2'] ?>) == 1){
        count++;
        var array = check();
        hantei1.push(array['num']);
        changeblack = blackCheck(hantei1, hantei2);
        for(var i=0; i<changeblack.length; i++){
            hantei2.splice($.inArray(changeblack[i], hantei2), 1);
            hantei1.push(changeblack[i]);
        }
        view();
        result();
    }
    if(parseInt(<?= $_GET['select'] ?>) == 1){
        $("#sample2").show();
    }else{
        $("#sample2").hide();
    }
    if(count % 2 == 1){
        $("#text").html("<br>白(○)の順番です。");
    }else{
        $("#text").html("<br>黒(●)の順番です。");
    }
    view();
    result();
}

$(document).on('click', '#select', function(){
    var val = $('input[name="select"]:checked').val();
    if(val != 1){
        $("#sample2").hide();
    }else{
        $("#sample2").show();
    }
});

function view(){
    for(var i=0; i<hantei1.length; i++){
        $("#button" + hantei1[i]).text("●");
    }
    for(var i=0; i<hantei2.length; i++){
        $("#button" + hantei2[i]).text("○");
    }
    $("#text2").html("<br>黒(●) " + hantei1.length + "　白(○) " + hantei2.length);
}

/**
$(document).on('click', '#pass', function(){
    count++;
    if(count % 2 == 1){
        $("#text").html("<br>白(○)の順番です。");
    }else{
        $("#text").html("<br>黒(●)の順番です。");
    }
});
*/

function player(num){
    count++;
    if(count % 2 == 1){
        var changeblack = [];
        hantei1.push(num);
        changeblack = blackCheck(hantei1, hantei2);
        //console.log(changeblack);
        if(changeblack.length == 0){
            count--;
            hantei1.splice($.inArray(num, hantei1), 1);
            alert('この場所には置けません!');
        }else{
            //$("#button" + num).text("●");
            for(var i=0; i<changeblack.length; i++){
                hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                hantei1.push(changeblack[i]);
                //$("#button" + changeblack[i]).text("●");
            }
        }
    }else{
        var changewhite = [];
        hantei2.push(num);
        changewhite = whiteCheck(hantei1, hantei2);
        //console.log(changewhite);
        if(changewhite.length == 0){
            count--;
            hantei2.splice($.inArray(num, hantei2), 1);
            alert('この場所には置けません!');
        }else{
            //$("#button" + num).text("○");
            for(var i=0; i<changewhite.length; i++){
                hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                hantei2.push(changewhite[i]);
                //$("#button" + changewhite[i]).text("○");
            }
        }
    }
    //console.log(hantei1);
    //onsole.log(hantei2);
    if(count % 2 == 1){
        $("#text").html("<br>白(○)の順番です。");
    }else{
        $("#text").html("<br>黒(●)の順番です。");
    }
    view();
    result();
}

function player2(num){
    count++;
    if(count % 2 == 1){
        var changeblack = [];
        hantei1.push(num);
        changeblack = blackCheck(hantei1, hantei2);
        //console.log(changeblack);
        if(changeblack.length == 0){
            count--;
            hantei1.splice($.inArray(num, hantei1), 1);
            alert('この場所には置けません!');
        }else{
            //$("#button" + num).text("●");
            for(var i=0; i<changeblack.length; i++){
                hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                hantei1.push(changeblack[i]);
                //$("#button" + changeblack[i]).text("●");
            }
            if(hantei1.length + hantei2.length < 64){
                count++;
                var array = check();
                if(array['max'] == 0){
                    //count--;
                    alert('cpuはパスです!');
                }else{
                    //result();
                    hantei2.push(array['num']);
                    changewhite = whiteCheck(hantei1, hantei2);
                    for(var i=0; i<changewhite.length; i++){
                        hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                        hantei2.push(changewhite[i]);
                    }
                    //result();
                }
            }
        }
    }else{
        var changewhite = [];
        hantei2.push(num);
        changewhite = whiteCheck(hantei1, hantei2);
        //console.log(changewhite);
        if(changewhite.length == 0){
            count--;
            hantei2.splice($.inArray(num, hantei2), 1);
            alert('この場所には置けません!');
        }else{
            //$("#button" + num).text("●");
            for(var i=0; i<changewhite.length; i++){
                hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                hantei2.push(changewhite[i]);
                //$("#button" + changewhite[i]).text("●");
            }
            if(hantei1.length + hantei2.length < 64){
                count++;
                var array = check();
                if(array['max'] == 0){
                    //count--;
                    alert('cpuはパスです!');
                }else{
                    //result();
                    hantei1.push(array['num']);
                    changeblack = blackCheck(hantei1, hantei2);
                    for(var i=0; i<changeblack.length; i++){
                        hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                        hantei1.push(changeblack[i]);
                    }
                    //result();
                }
            }
        }
    }
    //console.log(hantei1);
    //console.log(hantei2);
    view();
    result();
}

function check(){
    var maxchange = 0;
    var cpu = 0;
    var result = [];
    var kekka = 0;
    for(var i=0; i<64; i++){
        flag = false;
        for(var j=0; j<hantei1.length; j++){
            if(i == hantei1[j]){
                flag = true;
            }
        }
        for(var j=0; j<hantei2.length; j++){
            if(i == hantei2[j]){
                flag = true;
            }
        }
        if(flag == false){
            if(count % 2 == 1){
                hantei1.push(i);
                changeblack = blackCheck(hantei1, hantei2);
                result.push(changeblack.length);
                if(maxchange < changeblack.length){
                    maxchange = changeblack.length;
                    cpu = i;
                }
                hantei1.pop(i);
            }else{
                hantei2.push(i);
                changewhite = whiteCheck(hantei1, hantei2);
                result.push(changewhite.length);
                if(maxchange < changewhite.length){
                    maxchange = changewhite.length;
                    cpu = i;
                }
                hantei2.pop(i);
            }
        }
    }
    kekka = Math.max.apply(null, result);
    return {
        max: kekka,
        num: cpu
    };
}

function result(){
    if(hantei1.length + hantei2.length == 64){
        if(hantei1.length > hantei2.length){
            alert('黒の勝ち!');
            $("#text").html("<br>黒(●)の勝ちです!");
        }else if(hantei1.length < hantei2.length){
            alert('白の勝ち!');
            $("#text").html("<br>白(○)の勝ちです!");
        }else{
            alert('引き分け');
            $("#text").html("<br>引き分けです!");
        }
        view();
    }else{
        count++;
        var array = check();
        if(array['max'] == 0){
            if(parseInt(<?= $_GET['select'] ?>) == 1 && parseInt(<?= $_GET['select2'] ?>) == 0){
                alert('パスです。');
                //count++;
                var array2 = check();
                hantei2.push(array2['num']);
                changewhite = whiteCheck(hantei1, hantei2);
                for(var i=0; i<changewhite.length; i++){
                    hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                    hantei2.push(changewhite[i]);
                }
                view();
            }else if(parseInt(<?= $_GET['select'] ?>) == 1 && parseInt(<?= $_GET['select2'] ?>) == 1){
                alert('パスです。');
                //count++;
                var array2 = check();
                hantei1.push(array2['num']);
                changeblack = blackCheck(hantei1, hantei2);
                for(var i=0; i<changeblack.length; i++){
                    hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                    hantei1.push(changeblack[i]);
                }
                view();
            }else{
                alert('パスです。');
                if(count % 2 == 1){
                    $("#text").html("<br>白(○)の順番です。");
                }else{
                    $("#text").html("<br>黒(●)の順番です。");
                }
            }
            /** 
            if(hantei1.length + hantei2.length == 64){
                if(hantei1.length > hantei2.length){
                    alert('黒の勝ち!');
                    $("#text").html("<br>黒(●)の勝ちです!");
                }else if(hantei1.length < hantei2.length){
                    alert('白の勝ち!');
                    $("#text").html("<br>白(○)の勝ちです!");
                }else{
                    alert('引き分け');
                    $("#text").html("<br>引き分けです!");
                }
                view();
            }
            */
        }else{
            count--;
        }
    }
    for(var i=0; i<hantei1.length; i++){
        $("#button" + hantei1[i]).prop("disabled", true);
    }
    for(var i=0; i<hantei2.length; i++){
        $("#button" + hantei2[i]).prop("disabled", true);
    }
}

function blackCheck(black, white){
    var result = [];
    var resultblack = [];
    var num = black[black.length-1];

    //右側判定処理
    for(var i=0; i<8; i++){
        if(num <= 7+8*i){
            var right = 7+8*i;
            break;
        }
    }
    var a = num+1;
    while(a <= right){
        if(a == right){
            result.length = 0;
            break;
        }
        if($.inArray(a, white) !== -1){
            result.push(a);
            if($.inArray(a+1, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        a++;
    }

    //左側判定処理
    for(var i=1; i<9; i++){
        if(num < 8*i){
            var left = 8*(i-1);
            break;
        }
    }

    var b = num-1;
    while(b >= left){
        if(b == left){
            result.length = 0;
            break;
        }
        if($.inArray(b, white) !== -1){
            result.push(b);
            if($.inArray(b-1, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        b--;
    }

    //上側判定処理
    var top = num % 8;
    var m = num - 8;
    while(m >= top){
        if(m == top){
            result.length = 0;
            break;
        }
        if($.inArray(m, white) !== -1){
            result.push(m);
            if($.inArray(m-8, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        m -= 8;
    }

    //下側判定処理
    var bottom = num % 8 + 56;
    var o = num + 8;
    while(o <= bottom){
        if(o == bottom){
            result.length = 0;
            break;
        }
        if($.inArray(o, white) !== -1){
            result.push(o);
            if($.inArray(o+8, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        o += 8;
    }

    //左上側判定処理
    var upperleft = num;
    while(upperleft > 7){
        if(upperleft % 8 == 0){
            break;
        }
        upperleft -= 9;
    }

    var q = num - 9;
    while(q >= upperleft){
        if(q == upperleft){
            result.length = 0;
            break;
        }
        if($.inArray(q, white) !== -1){
            result.push(q);
            if($.inArray(q-9, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        q -= 9;
    }

    //右上側判定処理
    var upperright = num;
    while(upperright > 7){
        if(upperright % 8 == 7){
            break;
        }
        upperright -= 7;
    }

    var s = num - 7;
    while(s >= upperright){
        if(s == upperright){
            result.length = 0;
            break;
        }
        if($.inArray(s, white) !== -1){
            result.push(s);
            if($.inArray(s-7, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        s -= 7;
    }

    //左下側判定処理
    var lowerleft = num;
    while(lowerleft < 56){
        if(lowerleft % 8 == 0){
            break;
        }
        lowerleft += 7;
    }

    var u = num + 7;
    while(u <= lowerleft){
        if(u == lowerleft){
            result.length = 0;
            break;
        }
        if($.inArray(u, white) !== -1){
            result.push(u);
            if($.inArray(u+7, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        u += 7;
    }

    //右下側判定処理
    var lowerright = num;
    while(lowerright < 56){
        if(lowerright % 8 == 7){
            break;
        }
        lowerright += 9;
    }

    var w = num + 9;
    while(w <= lowerright){
        if(w == lowerright){
            result.length = 0;
            break;
        }
        if($.inArray(w, white) !== -1){
            result.push(w);
            if($.inArray(w+9, black) !== -1){
                for(var i=0; i<result.length; i++){
                    resultblack.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        w += 9;
    }
    return resultblack;
}

function whiteCheck(black, white){
    var num = white[white.length-1];
    var j = num+1;
    var k = num-1;
    var l = num-8;
    var n = num+8;
    var p = num-9;
    var r = num-7;
    var t = num+7;
    var v = num+9;
    var result = [];
    var resultwhite = [];

    //右側判定処理
    for(var i=0; i<8; i++){
        if(num <= 7+8*i){
            var right = 7+8*i;
            break;
        }
    }
    while(j <= right){
        if(j == right){
            result.length = 0;
            break;
        }
        if($.inArray(j, black) !== -1){
            result.push(j);
            if($.inArray(j+1, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        j++;
    }

    //左側判定処理
    for(var i=1; i<9; i++){
        if(num < 8*i){
            var left = 8*(i-1);
            break;
        }
    }
    while(k >= left){
        if(k == left){
            result.length = 0;
            break;
        }
        if($.inArray(k, black) !== -1){
            result.push(k);
            if($.inArray(k-1, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        k--;
    }

    //上側判定処理
    var top = num % 8;
    var m = l;
    while(m >= top){
        if(m == top){
            result.length = 0;
            break;
        }
        if($.inArray(m, black) !== -1){
            result.push(m);
            if($.inArray(m-8, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        m -= 8;
    }

    //下側判定処理
    var bottom = num % 8 + 56;
    var o = n;
    while(o <= bottom){
        if(o == bottom){
            result.length = 0;
            break;
        }
        if($.inArray(o, black) !== -1){
            result.push(o);
            if($.inArray(o+8, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        o += 8;
    }

    //左上側判定処理
    var upperleft = num;
    while(upperleft > 7){
        if(upperleft % 8 == 0){
            break;
        }
        upperleft -= 9;
    }

    var q = p;
    while(q >= upperleft){
        if(q == upperleft){
            result.length = 0;
            break;
        }
        if($.inArray(q, black) !== -1){
            result.push(q);
            if($.inArray(q-9, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        q -= 9;
    }

    //右上側判定処理
    var upperright = num;
    while(upperright > 7){
        if(upperright % 8 == 7){
            break;
        }
        upperright -= 7;
    }

    var s = r;
    while(s >= upperright){
        if(s == upperright){
            result.length = 0;
            break;
        }
        if($.inArray(s, black) !== -1){
            result.push(s);
            if($.inArray(s-7, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        s -= 7;
    }

    //左下側判定処理
    var lowerleft = num;
    while(lowerleft < 56){
        if(lowerleft % 8 == 0){
            break;
        }
        lowerleft += 7;
    }

    var u = t;
    while(u <= lowerleft){
        if(u == lowerleft){
            result.length = 0;
            break;
        }
        if($.inArray(u, black) !== -1){
            result.push(u);
            if($.inArray(u+7, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        u += 7;
    }

    //右下側判定処理
    var lowerright = num;
    while(lowerright < 56){
        if(lowerright % 8 == 7){
            break;
        }
        lowerright += 9;
    }

    var w = v;
    while(w <= lowerright){
        if(w == lowerright){
            result.length = 0;
            break;
        }
        if($.inArray(w, black) !== -1){
            result.push(w);
            if($.inArray(w+9, white) !== -1){
                for(var i=0; i<result.length; i++){
                    resultwhite.push(result[i]);
                }
            }
        }else{
            result.length = 0;
            break;
        }
        w += 9;
    }
    return resultwhite;
}
</script>
<form method="GET" action="sample.php">
    <div id="sample">
    <input type="radio" id="select" name="select" value="0" checked>手動
    <input type="radio" id="select" name="select" value="1" <?php if(isset($_GET['select']) && $_GET['select'] == 1) echo 'checked' ?>>CPU<br>
    <span id="sample2">
    <input type="radio" id="select2" name="select2" value="0" checked>先攻
    <input type="radio" id="select2" name="select2" value="1" <?php if(isset($_GET['select2']) && $_GET['select2'] == 1) echo'checked' ?>>後攻
    </span>
    <input type="submit" value="決定">
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
