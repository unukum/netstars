<?php
/**
 * 保存记录
 */
function saveLog(){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $createTime = date('Y-M-d',time());
    $addData = [];
    M()->add($addData);
}

/**
 * 检查记录
 */
function checkoutLog(){

}