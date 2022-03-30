<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memory;
use App\Models\Family;
use App\Models\Filter;


class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //思い出ふりかえり（Pickup思い出、お子さまごと、年月ごと）一覧画面
    public function index()
    {
        $user = Auth::user();

        //family_id設定済の場合
        if (isset($user->userDetail->family))
        {
            $family = $user->userDetail->family;
            $child_list = Family::find($user->userDetail->family->id)->children;

            $memory = Memory::inRandomOrder()
                ->where('family_id', $family->id)->first();

            $count_month = Filter::countMonthFamily($family);
            if (isset($count_month))
            {
                $month_list = Filter::makeMonthListFamily($family, $count_month);

            //思い出が一つも登録されていない場合
            } else {
                $month_list = null;
            }

        } else {
        //family_id未設定の場合
            $child_list = null;

            $memory = Memory::inRandomOrder()
                ->where('user_id', $user->id)->first();

            $count_month = Filter::countMonthUser($user);
            if (isset($count_month))
            {
                $month_list = Filter::makeMonthListUser($user, $count_month);

            //思い出が一つも登録されていない場合
            } else {
                $month_list = null;
            }
        }

        return view('filters.index', compact('memory','child_list','month_list'));

    }

    //お子さまごとの思い出一覧を表示
    public function showByChild(Request $request) //お子さま登録済＝family_id設定済
    {
        $child_id = $request->child_id;
        $user = Auth::user();
        $family = $user->userDetail->family;
        $query = Memory::childFilter($child_id);

        //検索窓とページネーション
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $query->where('body', 'like', '%' . $keyword . '%');
        }

        $memories = $query->paginate(5);

        return view('filters.show_child', compact('child_id','memories', 'keyword'));
    }

    //年月ごとの思い出一覧を表示
    public function showByMonth(Request $request)
    {
        $user = Auth::user();
        $month_year = $request->month_year;
        $query = Memory::monthFilter($month_year);

        //family_id設定済の場合
        if (isset($user->userDetail->family))
        {
            $family = $user->userDetail->family;
            $query->where('family_id', $family->id);

        //family_id未設定の場合
        } else {
            $query->where('user_id', $user->id);
        }

        //検索窓とページネーション
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $query->where('body', 'like', '%' . $keyword . '%');
        }

        $memories = $query->paginate(5);

        return view('filters.show_month', compact('month_year','memories', 'keyword'));
    }
}
