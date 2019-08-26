<?php
/**
 * Created by IntelliJ IDEA.
 * User: sixnqq
 * Date: 4. 05. 2019
 * Time: 13:47
 */

function setActive(string $path, string $class_name = "active")
{
    $paramUrl1 = explode("/", Request::path())[0];
    $returnUrl = $paramUrl1 != '' ? $paramUrl1 : '/';
    return $returnUrl === $path ? $class_name : "";
}

function getCurrentPage()
{
    $url = Request::path() === '/' ? '' : Request::path();

    return explode('/', $url);
}