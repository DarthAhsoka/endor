<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/14
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/24 0.8 优化名字空间,加载器代码优化
 */
namespace endor;
/**
 * 模块自动加载器
 *
 */
spl_autoload_register("endor\EndorAutoLoader::autoload");
// 框架自动载入
class EndorAutoLoader
{
    static public function autoload($className)
    {
        $className = str_replace("\\","/",$className);
        $path = dirname(__DIR__)."/".$className;
        $file1 = $path.".php";
        if(is_file($file1)){
            include_once $file1;
        }
    }
}