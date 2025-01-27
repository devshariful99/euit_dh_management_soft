<?php

use Illuminate\Support\Facades\Route;
use League\Csv\Writer;
use App\Models\Permission;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


function storage_url($urlOrArray)
{
    if (is_array($urlOrArray) || is_object($urlOrArray)) {
        $result = '';
        $count = 0;
        $itemCount = count($urlOrArray);
        foreach ($urlOrArray as $index => $url) {

            $result .= !empty($url) ? asset('storage/' . $url) : asset('frontend\default\cat_img.png');

            if ($count === $itemCount - 1) {
                $result .= '';
            } else {
                $result .= ', ';
            }
            $count++;
        }
        return $result;
    } else {
        return !empty($urlOrArray) ? asset('storage/' . $urlOrArray) : asset('frontend\default\cat_img.png');
    }
}

function timeFormate($time)
{
    $dateFormat = env('DATE_FORMAT', 'd-M-Y');
    // $timeFormat = env('TIME_FORMAT', 'H:i A');
    // return date($dateFormat . " " . $timeFormat, strtotime($time));
    return date($dateFormat, strtotime($time));
}

function admin()
{
    return auth()->guard('web')->user();
}
function client()
{
    return auth()->guard('client')->user();
}

function availableTimezones()
{
    $timezones = [];
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();

    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $timezone = new DateTimeZone($timezoneIdentifier);
        $offset = $timezone->getOffset(new DateTime());
        $offsetPrefix = $offset < 0 ? '-' : '+';
        $offsetFormatted = gmdate('H:i', abs($offset));

        $timezones[] = [
            'timezone' => $timezoneIdentifier,
            'name' => "(UTC $offsetPrefix$offsetFormatted) $timezoneIdentifier",
        ];
    }

    return $timezones;
}

function file_name_from_url($url = null)
{
    if ($url) {
        $fileNameWithExtension = basename($url);
        return $fileNameWithExtension;
    }
}


function file_title_from_url($url = null)
{
    if ($url) {
        $fileTitle = pathinfo($url, PATHINFO_FILENAME);
        return $fileTitle;
    }
}
function removeHttpProtocol($url)
{
    return str_replace(['http://', 'https://'], '', $url);
}

function str_limit($data, $limit = 20, $end = '...')
{
    return Str::limit($data, $limit, $end);
}

function getModelName($className)
{
    $className = basename(str_replace('\\', '/', $className));
    return trim(preg_replace('/(?<!\ )[A-Z]/', ' $0', $className));
}

function invoiceNumber()
{
    return date("Ym-j");
}