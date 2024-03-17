var hantei1 = [28, 35]; //黒の置かれている場所
var hantei2 = [27, 36]; //白の置かれている場所
var corner = [0, 7, 56, 63];
var count = 0; //手数をカウント
bool = true;
nextflag = false;

/**
 * 画面読み込み時の処理
 */
window.onload = () => {
    if($_GET('assist')){
        nextflag = true;
    }
    if(parseInt($_GET('select')) == 1 && parseInt($_GET('select2')) == 1){
        view();
        fix();
        count++;
        var array = check();
        hantei1.push(array['num']);
        changeblack = blackCheck(hantei1, hantei2);
        for(var i=0; i<changeblack.length; i++){
            hantei2.splice($.inArray(changeblack[i], hantei2), 1);
            hantei1.push(changeblack[i]);
        }
        setTimeout(() => {
            view();
            nextflag ? next() : nextoff();
            result();
        }, 500);
    }else{
        view();
        nextflag ? next() : nextoff();
        result();
    }
    parseInt($_GET('select')) == 1 ? $("#sample2").show() : $("#sample2").hide();
    var str = count % 2 == 1 ? '<br><span id="whitecircle2"></span>の順番です。' : '<br><span id="blackcircle2"></span>の順番です。';
    $("#text").html(str);
}

/**
 * 「アシスト」選択処理
 */
$(document).on('click', '#assist', function(){
    var val = $('input[name="assist"]:checked').val();
    if(val){
        nextflag = true;
        next();
    }else{
        nextflag = false;
        nextnone();
        nextoff();
    }
});

/**
 * 「手動」「CPU」選択処理
 */
$(document).on('click', '#select', function(){
    var val = $('input[name="select"]:checked').val();
    val != 1 ? $("#sample2").hide() : $("#sample2").show();
});

/**
 * 「パス」ボタンクリック時の処理
 */
$(document).on('click', '#pass', function(){
    count++;
    var str = count % 2 == 1 ? '<br><span id="whitecircle2"></span>の順番です。' : '<br><span id="blackcircle2"></span>の順番です。';
    $("#text").html(str);
    nextflag ? next() : nextoff();
});

/**
 * パラメータの値を取得
 * @param {string} param パラメータ
 * @return {string}
 */
function $_GET(param) {
    return new URL(location).searchParams.get(param);
}

/**
 * 盤面等を描画
 */
function view(){
    for(var i=0; i<64; i++){
        $("#button" + i).removeClass("kuro");
        $("#button" + i).removeClass("shiro");
    }
    nextnone();
    for(var i=0; i<hantei1.length; i++){
        $("#button" + hantei1[i]).addClass("kuro");
    }
    for(var i=0; i<hantei2.length; i++){
        $("#button" + hantei2[i]).addClass("shiro");
    }
    $("#text2").html('<br><span id="blackcircle"></span><span id="num">' + hantei1.length + '</span><span id="whitecircle"></span><span id="num">' + hantei2.length + "</span>");
}

/**
 * アシストの描画
 */
function next(){
    count++;
    var array = check();
    nextnone();
    for(var i=0; i<64; i++){
        if(!array['next'].includes(i)){
            $("#button" + i).prop("disabled", true);
        }else{
            $("#button" + i).prop("disabled", false);
            count % 2 == 1 ? $("#button" + i).addClass("black") : $("#button" + i).addClass("white");
        }
    }
    count--;
}

/**
 * アシストの描画を止める
 */
function nextnone(){
    for(var i=0; i<64; i++){
        $("#button" + i).removeClass("black");
        $("#button" + i).removeClass("white");
    }
}

/**
 * 盤面ボタンのロックを外す
 */
function nextoff(){
    for(var i=0; i<64; i++){
        $("#button" + i).prop("disabled", false);
    }
}

/**
 * 盤面ボタンをロックする
 */
function fix(){
    for(var i=0; i<64; i++){
        $("#button" + i).prop("disabled", true);
    }
}

/**
 * 「手動」選択時の処理
 * @param {number} num 盤面の場所
 */
function player(num){
    count++;
    if(count % 2 == 1){
        var changeblack = [];
        hantei1.push(num);
        changeblack = blackCheck(hantei1, hantei2);
        if(changeblack.length == 0){
            count--;
            hantei1.splice($.inArray(num, hantei1), 1);
            alert('この場所には置けません!');
        }else{
            for(var i=0; i<changeblack.length; i++){
                hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                hantei1.push(changeblack[i]);
            }
        }
    }else{
        var changewhite = [];
        hantei2.push(num);
        changewhite = whiteCheck(hantei1, hantei2);
        if(changewhite.length == 0){
            count--;
            hantei2.splice($.inArray(num, hantei2), 1);
            alert('この場所には置けません!');
        }else{
            for(var i=0; i<changewhite.length; i++){
                hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                hantei2.push(changewhite[i]);
            }
        }
    }
    var str = count % 2 == 1 ? '<br><span id="whitecircle2"></span>の順番です。' : '<br><span id="blackcircle2"></span>の順番です。';
    $("#text").html(str);
    view();
    nextflag ? next() : nextoff();
    result();
}

/**
 * 「CPU」選択時の処理
 * @param {number} num 盤面の場所
 * @return {undefined} 例外
 */
function player2(num){
    if(!(hantei1.includes(num) || hantei2.includes(num))){
        flag2 = true;
        count++;
        if(count % 2 == 1){
            if(!bool){
                count--;
            }
            var changeblack = [];
            hantei1.push(num);
            changeblack = blackCheck(hantei1, hantei2);
            if(changeblack.length == 0){
                count--;
                hantei1.splice($.inArray(num, hantei1), 1);
                if(!bool){
                    return;
                }
                alert('この場所には置けません!');
            }else{
                for(var i=0; i<changeblack.length; i++){
                    hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                    hantei1.push(changeblack[i]);
                }
                if(bool){
                    view();
                    fix();
                }else{
                    fix();
                }
                if(hantei1.length + hantei2.length < 64){
                    count++;
                    var array = check();
                    if(array['max'] == 0){
                        alert('cpuはパスです!');
                    }else{
                        //CPUの打つ手を記述
                        if(bool){
                            for(var i=0; i<corner.length; i++){
                                if(array['next'].includes(corner[i])){
                                    flag2 = false;
                                    hantei2.push(corner[i]);
                                    break;
                                }
                            }
                            if(flag2){
                                hantei2.push(array['num']);
                            }
                            changewhite = whiteCheck(hantei1, hantei2);
                            for(var i=0; i<changewhite.length; i++){
                                hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                                hantei2.push(changewhite[i]);
                            }
                        }
                    }
                }
                if(!bool){
                    bool = true;
                }
            }
        }else{
            if(!bool){
                count--;
            }
            var changewhite = [];
            hantei2.push(num);
            changewhite = whiteCheck(hantei1, hantei2);
            if(changewhite.length == 0){
                count--;
                hantei2.splice($.inArray(num, hantei2), 1);
                if(!bool){
                    return;
                }
                alert('この場所には置けません!');
            }else{
                for(var i=0; i<changewhite.length; i++){
                    hantei1.splice($.inArray(changewhite[i], hantei1), 1);
                    hantei2.push(changewhite[i]);
                }
                if(bool){
                    view();
                    fix();
                }else{
                    fix();
                }
                if(hantei1.length + hantei2.length < 64){
                    count++;
                    var array = check();
                    if(array['max'] == 0){
                        alert('cpuはパスです!');
                    }else{
                        //CPUの打つ手を記述
                        if(bool){
                            for(var i=0; i<corner.length; i++){
                                if(array['next'].includes(corner[i])){
                                    flag2 = false;
                                    hantei1.push(corner[i]);
                                    break;
                                }
                            }
                            if(flag2){
                                hantei1.push(array['num']);
                            }
                            changeblack = blackCheck(hantei1, hantei2);
                            for(var i=0; i<changeblack.length; i++){
                                hantei2.splice($.inArray(changeblack[i], hantei2), 1);
                                hantei1.push(changeblack[i]);
                            }
                        }
                    }
                }
                if(!bool){
                    bool = true;
                }
            }
        }
        setTimeout(() => {
            view();
            nextflag ? next() : nextoff();
            result();
        }, 500);
    }
}

/**
 * countの値により黒または白の以下情報を返す
 * @return {number} max ひっくり返す最大個数
 * @return {number} num 最大個数ひっくり返す場所
 * @return {array} next 駒が置ける場所
 */
function check(){
    var maxchange = 0;
    var cpu = 0;
    var result = [];
    var list = [];
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
        if(!flag){
            if(count % 2 == 1){
                hantei1.push(i);
                changeblack = blackCheck(hantei1, hantei2);
                result.push(changeblack.length);
                if(changeblack.length > 0){
                    list.push(i);
                }
                if(maxchange < changeblack.length){
                    maxchange = changeblack.length;
                    cpu = i;
                }
                hantei1.pop(i);
            }else{
                hantei2.push(i);
                changewhite = whiteCheck(hantei1, hantei2);
                result.push(changewhite.length);
                if(changewhite.length > 0){
                    list.push(i);
                }
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
        num: cpu,
        next: list
    };
}

/**
 * 勝敗やパスを判定する
 */
function result(){
    if(hantei1.length + hantei2.length == 64){
        if(hantei1.length > hantei2.length){
            alert('黒の勝ち!');
            $("#text").html('<br><span id="blackcircle2"></span>の勝ちです!');
            $("#pass").hide();
        }else if(hantei1.length < hantei2.length){
            alert('白の勝ち!');
            $("#text").html('<br><span id="whitecircle2"></span>の勝ちです!');
            $("#pass").hide();
        }else{
            alert('引き分け');
            $("#text").html("<br>引き分けです!");
            $("#pass").hide();
        }
    }else if(hantei2.length == 0 && hantei1.length > 0){
        alert('黒の勝ち!');
        $("#text").html('<br><span id="blackcircle2"></span>の勝ちです!');
        $("#pass").hide();
    }else if(hantei1.length == 0 && hantei2.length > 0){
        alert('白の勝ち!');
        $("#text").html('<br><span id="whitecircle2"></span>の勝ちです!');
        $("#pass").hide();
    }else{
        count++;
        var array = check();
        count++;
        var array2 = check();
        count--;
        if(array['max'] == 0 && array2['max'] == 0){
            if(hantei1.length > hantei2.length){
                alert('黒の勝ち!');
                $("#text").html('<br><span id="blackcircle2"></span>の勝ちです!');
                $("#pass").hide();
            }else if(hantei1.length < hantei2.length){
                alert('白の勝ち!');
                $("#text").html('<br><span id="whitecircle2"></span>の勝ちです!');
                $("#pass").hide();
            }else{
                alert('引き分け');
                $("#text").html("<br>引き分けです!");
                $("#pass").hide();
            }
        }
        if(array['max'] == 0){
            if(parseInt($_GET('select')) == 1){
                alert('パスです');
                bool = false;
                player2(array2['num']);
            }else{
                alert('パスです');
                var str = count % 2 == 1 ? '<br><span id="whitecircle2"></span>の順番です。' : '<br><span id="blackcircle2"></span>の順番です。';
                $("#text").html(str);
                nextflag ? next() : nextoff();
            }
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

/**
 * 黒を置いたときにひっくり返す場所を返す
 * @param {array} black 黒の置かれている場所
 * @param {array} white 白の置かれている場所
 * @return {array} resultblack 白から黒に変わる場所
 */
function blackCheck(black, white){
    var num = black[black.length-1];
    var a = num + 1;
    var b = num - 1;
    var m = num - 8;
    var o = num + 8;
    var q = num - 9;
    var s = num - 7;
    var u = num + 7;
    var w = num + 9;
    var result = [];
    var resultblack = [];

    //右側判定処理
    for(var i=0; i<8; i++){
        if(num <= 7+8*i){
            var right = 7+8*i;
            break;
        }
    }
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

/**
 * 白を置いたときにひっくり返す場所を返す
 * @param {array} black 黒の置かれている場所
 * @param {array} white 白の置かれている場所
 * @return {array} resultwhite 黒から白に代わる場所
 */
function whiteCheck(black, white){
    var num = white[white.length-1];
    var j = num + 1;
    var k = num - 1;
    var m = num - 8;
    var o = num + 8;
    var q = num - 9;
    var s = num - 7;
    var u = num + 7;
    var w = num + 9;
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
