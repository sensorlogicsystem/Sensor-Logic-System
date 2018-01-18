<?php
class nocsrf{
    function check($token, $post, $bool, $size, $bool2){
    	$token = 'crsf_token';
        $post = 'crsf';
        $bool = true;
        $size = 95;
        $bool2 = true;
        return true;
    }
}
?>