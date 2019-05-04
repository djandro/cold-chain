<?php
/**
 * Created by IntelliJ IDEA.
 * User: sixnqq
 * Date: 4. 05. 2019
 * Time: 13:47
 */

function setActive(string $path, string $class_name = "active")
{
    return Request::path() === $path ? $class_name : "";
}

function getCurrentPage()
{
    $url = Request::path() === '/' ? '':Request::path();
    return $url;
}