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

if (! function_exists('getProducts')) {
    function getProducts($json = false)
    {
        $products = \App\Product::orderBy('id', 'desc')->get(['id', 'name']);

        if ($json) Response::json($products);
        return $products;
    }
}

if (! function_exists('getLocations')) {
    function getLocations($json = false)
    {
        $locations = \App\Location::orderBy('id', 'desc')->get(['id', 'name']);

        if ($json) Response::json($locations);
        return $locations;
    }
}

if (! function_exists('getDevices')) {
    function getDevices($json = false)
    {
        $devices = \App\Device::get(['id', 'name']);

        if ($json) Response::json($devices);
        return $devices;
    }
}

if (! function_exists('getRecords')) {
    function getRecords($json = false)
    {
        $records = \App\Records::orderBy('id', 'desc')->paginate(10);

        if ($json) Response::json($records);
        return $records;
    }
}