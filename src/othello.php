<?php
class Othello{
    //初期盤面の値を生成
    public function getValue($x, $y){
        $result[$x][$y] = "";

        if($x == 3 && $y == 3){
            $result[$x][$y] = "○";
        }
        if($x == 3 && $y == 4){
            $result[$x][$y] = "●";
        }
        if($x == 4 && $y == 3){
            $result[$x][$y] = "●";
        }
        if($x == 4 && $y == 4){
            $result[$x][$y] = "○";
        }

        return $result[$x][$y];
    }
}
?>
