<?php

namespace Composer\web;
class FilterClass
{
    static function setFilter($category, $month = 0, $findcategory = 0, $method = 0)
    {
        if ($method == "all") return null;
        //set date
        $date_filter = self::setDateFilter($month);

        if ($date_filter != 0) {
            if (isset($_COOKIE["year"]) and $month != 0) {
                $day = cal_days_in_month(CAL_GREGORIAN, $month, $_COOKIE['year']);
                $now = date("{$_COOKIE["year"]}-{$month}-{$day}");
            } else if (isset($_COOKIE["year"]))
                $now = date("{$_COOKIE["year"]}-12-31");
            else
                $now = date("Y-n-j");
            $filters['date'] = "date BETWEEN '{$date_filter}' AND '{$now}'";
        } else {
            $filters["date"] = null;
        }
        //set category
        $category_filter = self::setCategoryFilter($category, $findcategory);
        if ($category_filter != 0) {
            $filters['category'] = "category='{$category_filter}'";
        } else {
            $filters["category"] = null;
        }

        return $filters;

    }


    private static function setDateFilter($month = 0)
    {
        if (isset($_COOKIE["year"]) and $month != 0) {
            $date_filter = date("{$_COOKIE["year"]}-{$month}-01");

        } else if (isset($_COOKIE["year"])) {
            $date_filter = date("{$_COOKIE["year"]}-01-01");

        } else if ($_COOKIE["date_filter"] == null or $_COOKIE["date_filter"] == "1month") {
            $date_filter = date("Y-n-01");

        } else {
            switch ($_COOKIE["date_filter"]) {

                case "all":
                    $date_filter = 0;
                    break;

                case "3month":
                    $month = date("m");
                    if ($month > 3)
                        $month -= 2;
                    else
                        $month += 10;
                    $date_filter = date("Y-{$month}-01");
                    break;

                case "year":
                    $date_filter = date("Y-01-01");
                    break;
            }
        }
        return $date_filter;
    }

    private static function setCategoryFilter($category, $findcategory = 0)
    {
        if ($findcategory != 0)
            return $category[$findcategory];
        else if ($_COOKIE["category_filter"] == "all" or $_COOKIE["category_filter"] == null or isset($_COOKIE["year"]))
            return 0;
        else
            return $category[$_COOKIE['category_filter']];

    }
}