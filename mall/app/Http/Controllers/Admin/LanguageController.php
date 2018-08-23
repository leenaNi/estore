<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Input;
use App\Library\Helper;
use Session;

class LanguageController extends Controller {

    public function index() {

        $languages = Language::paginate(Config('contstants.paginateNo'));
        return view(Config('constants.adminLanguageView') . '.index', compact('languages'));
    }

    public function addEdit() {
        $language = Language::find(Input::get("id"));
        $action = route('admin.language.save');
        return view(Config('constants.adminLanguageView') . '.addEdit', compact('language', 'action'));
    }

    public function save() {
        $language = Language::findOrNew(Input::get("id"));
        $language->name = Input::get("name");
        $language->status = Input::get("status");
        if (empty(Input::get('id'))) {
            Session::flash("msg", "Language added successfully.");
            $data = ['status' => "1", "message" => "Language added successfully."];
        } else {
            $data = ['status' => "1", "message" => "Language updated successfully."];
            Session::flash("msg", "Language updated successfully.");
        }
        $viewname = '';
        $language->save();
        return Helper::returnView($viewname, $data, $url = 'admin.language.view');
    }

    public function changeStatus() {
        $language = Language::find(Input::get("id"));
        if ($language->status == 1) {
            $status = 0;
            $language->status = $status;
            Session::flash("message", 'Language disabled successfully.');
            $language->save();
        } else if ($language->status == 0) {
            $status = 1;
            $language->status = $status;
            Session::flash("msg", 'Language enable successfully.');
            $language->save();
        }
        $viewname = '';
        $data = '';
        return Helper::returnView($viewname, $data, $url = 'admin.language.view');
    }

    public function delete() {
        $language = Language::find(Input::get("id"));
        $language->delete();
        Session::flash("message", "Language deleted successfully.");
        $data = ['status' => "1", "message" => "Language deleted successfully."];
        $viewname = '';

        return Helper::returnView($viewname, $data, $url = 'admin.language.view');
    }

}
