<?php
/**
 * 后台项目入口文件
 */
//获取请求
$requestUrl = $_SERVER['REQUEST_URI'];
//echo $requestUrl;
//分析请求 http://localhost/index.php/a?id=1&b=2 或者 http://localhost/index.php/a/id=1 这两种都可以 todo 先解析第一种
//操作字符串 index.php/a/way?id=1&way=3 分离出 className 和 methodName 和 参数
//获取$requestUrl中的?的位置 可以用 substr和strstr
$paramString = substr(strstr($requestUrl, '?'), 1);//返回id=1&b=2
//echo $paramString;
//使用&将字符串分割 然后使用=将每组分割 判断是否参数的key和value都存在
//$paramStringArray = explode('&', $paramString);
//if (count($paramStringArray) > 0) {
//    foreach ($paramStringArray as $k => $v) {
//        $v = explode('=', $v);
//        if (empty($v[1])) {
//            echo $v[0] . '参数错误';
//        }
//        $paramStringArray[$k] = $v;
//    }
//}
//分析出控制器名和方法名 http://localhost/index.php/a/b?id=1&b=2 todo bug 不携带问号的情况
$filePath = substr($requestUrl, 1, strpos($requestUrl, "?") - 1);// 0是一个空字符串
$filePathArray = explode('/', $filePath);
$controllerName = $filePathArray[1];
$wayName = $filePathArray[2];
//将文件加载进来
//$absolutePath = __FILE__;//定位到当前文件 D:\project\netstars\netstars\server\php\native\index.php
$absolutePath = $_SERVER['DOCUMENT_ROOT'];//定位到目录所在文件 D:/project/netstars/netstars/server/php/native
$commonSuffix = '.class.php';//统一文件后缀
if (!empty($controllerName)) {
    $wholeControllerName = $controllerName . $commonSuffix;
    $wholeControllerPath = $absolutePath . '/controller/' . $controllerName . $commonSuffix;
}
if (is_file($wholeControllerPath)) {
    require $wholeControllerPath;
    $object = new $controllerName;

    $object->$wayName();

}











