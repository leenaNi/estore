<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Models\Courier;
use App\Library\Helper;

class HomeController extends Controller {

    public function index() {

        if (!empty(config('app.industry'))) {
            $general_setting = GeneralSetting::where('is_question', 1)->where('name', '<>', 'set_popup')->orderBy('sort_order', 'DESC')->whereHas('industry', function($que) {
                $que->where("industry_id",config('app.industry'));
            });
        } else {
            $general_setting = GeneralSetting::where('is_question', 1)->where('is_active', 1)->where('name', '<>', 'set_popup')->orderBy('sort_order', 'DESC');
        }

        $general_setting = $general_setting->get();
     //  dd($general_setting);
        $courier = Courier::where("status", 1)->get(["name", "id"]);
        $set_popup = GeneralSetting::where('name', 'set_popup')->first();
        return view('Admin.pages.home.index', ['general_setting' => $general_setting, 'set_popup' => $set_popup, 'courier' => $courier]);
    }

    public function setPref() {
        return view('Admin.pages.home.setpref');
    }

    public function changePopupStatus() {
        $setting = GeneralSetting::where('name', 'set_popup')->update(['status' => 0]);
        if ($setting)
            echo 'success';
        else
            echo 'some error occure';
    }

  

    public function newsLetter() {

        $newsLetters = Notification::paginate(Config('constants.paginateNo'));

        return view('Admin.pages.home.newsLetter', ['newsLetters' => $newsLetters]);
    }

    public function exportNewsLetter() {

        $newsLetters = Notification::get();
        $arr = ['email', 'created_at'];
        $sampleProds = [];
        array_push($sampleProds, $arr);

        foreach ($newsLetters as $newsLetter) {
            $details = [
                $newsLetter->email,
                date('d M Y ', strtotime($newsLetter->created_at))
            ];
            array_push($sampleProds, $details);
        }



        return Helper::getCsv($sampleProds, 'newsletter.csv', ',');
    }

}
