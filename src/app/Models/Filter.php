<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Filter extends Model
{
    //最古の思い出投稿日時から最新の思い出投稿日時までの期間に含まれる月数を計算する（family_id設定後）
    public static function countMonthFamily($family)
    {
        //最古・最新の思い出投稿日時を取得
        $oldest_date = Memory::where('family_id', $family->id)->oldest()->first();
        $latest_date = Memory::where('family_id', $family->id)->latest()->first();

        //最古日時から最新日時までの期間に含まれる月数を計算する
        if(isset($oldest_date))
        {
            $month1 = date('Y', strtotime($oldest_date)) * 12 + date('m', strtotime($oldest_date->created_at));
            $month2 = date('Y', strtotime($latest_date)) * 12 + date('m', strtotime($latest_date->created_at));
            $count_month = $month2 - $month1 + 1;

        } else {
            $count_month = null;
        }

        return $count_month;
    }

    //最古の思い出投稿日時から最新の思い出投稿日時までの期間に含まれる月数を計算する（family_id設定前）
    public static function countMonthUser($user)
    {
        //最古・最新の思い出投稿日時を取得
        $oldest_date = Memory::where('user_id', $user->id)->oldest()->first();
        $latest_date = Memory::where('user_id', $user->id)->latest()->first();

        //最古日時から最新日時までの期間に含まれる月数を計算する
        if(isset($oldest_date))
        {
            $month1 = date('Y', strtotime($oldest_date)) * 12 + date('m', strtotime($oldest_date->created_at));
            $month2 = date('Y', strtotime($latest_date)) * 12 + date('m', strtotime($latest_date->created_at));
            $count_month = $month2 - $month1 + 1;

        } else {
            $count_month = null;
        }

        return $count_month;
    }

    //最古の思い出投稿日時から最新の思い出投稿日時までの各月を配列に入れる（family_id設定後）
    public static function makeMonthListFamily($family, $count_month)
    {
        //最古の思い出投稿月を取得
        $oldest_month = Memory::where('family_id', $family->id)->oldest()->first()->created_at;
        // $month_year = DateTimeImmutable::createFromFormat('Y-m-d', $oldest_month);
        $month_year = new DateTime($oldest_month);
        $month_year->modify('first day of 00:00:00');

        //配列に入れる
        $month_list = array();
        for($i = 0; $i < $count_month; $i++)
        {
            $string_month_year = $month_year->format('Y-m');
            $month_list[] = $string_month_year;
            $month_year->modify('next month');
        }

        return $month_list;
    }

    //最古の思い出投稿日時から最新の思い出投稿日時までの「YYYY年m月」を配列に入れる（family_id設定前）
    public static function makeMonthListUser($user, $count_month)
    {
        //最古の思い出投稿月を取得
        $oldest_month = Memory::where('user_id', $user->id)->oldest()->first()->created_at;
        $month_year = new DateTime($oldest_month);
        $month_year->modify('first day of 00:00:00');

        //配列に入れる
        $month_list = array();
        for($i = 0; $i < $count_month; $i++)
        {
            $string_month_year = $month_year->format('Y-m');
            $month_list[] = $string_month_year;
            $month_year->modify('next month');
        }

        return $month_list;

    }

}
