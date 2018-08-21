<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Library\Helper;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;

class LanguageController extends Controller {

    public function index() {
        $languages = Language::orderBy("id", "desc");

        $search = Input::get('search');

        if (!empty($search)) {

            if (!empty(Input::get('s_language'))) {
                $languages = $languages->where("name", "like", "%" . Input::get('s_language') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";

                $languages = $languages->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }

        $languages = $languages->paginate(Config('constants.AdminPaginateNo'));
        $data = [];
        $viewname = Config('constants.AdminPagesMastersLanguage') . ".index";
        $data['languages'] = $languages;

        return Helper::returnView($viewname, $data);
    }

    public function addEdit() {
        $language = Language::findOrNew(Input::get('id'));

        $data = [];
        $viewname = Config('constants.AdminPagesMastersLanguage') . ".addEdit";
        $data['language'] = $language;

        return Helper::returnView($viewname, $data);
    }

    public function saveUpdate() {
        $validation = new Language();
        $checkValidation = Helper::getValidation($validation, Input::all());

        if ($checkValidation == 1) {
            $saveUpdateCat = Language::findOrNew(Input::get('id'));
            $saveUpdateCat->fill(Input::all())->save();

            return redirect()->route('admin.masters.language.view');
        } else {
            return $checkValidation;
        }
    }

    public function changeStatus() {
        $catid = Input::get('catid');
        $catstatus = Input::get('catstatus');

        $cat = Language::find($catid);
        $cat->status = ($catstatus == 0) ? 1 : 0;
        $cat->update();
        return $cat->status;
    }

}
