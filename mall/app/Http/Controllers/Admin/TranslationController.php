<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Translation;
use Input;
use App\Library\Helper;
use Session;

class TranslationController extends Controller {

    public function index() {
        if (!empty(Input::get("translation"))) {
            $search = Input::get("translation");

            $translations = Translation::where('english', 'like', "%$search%")->get();
        } else {
            $translations = Translation::paginate(Config('constants.paginateNo'));
        }
        return view(Config('constants.adminTranslationView') . '.index', compact('translations'));
    }

    public function addEdit() {
        $translation = Translation::find(Input::get("id"));
        $action = route('admin.translation.save');
        return view(Config('constants.adminTranslationView') . '.addEdit', compact('translation', 'action'));
    }

    public function save() {
        $translation = Translation::findOrNew(Input::get("id"));
        $translation->hindi = Input::get("hindi");
        $translation->english = Input::get("english");
        $translation->bengali = Input::get("bengali");
        $translation->is_specific = Input::get('is_specific');
        $translation->translate_for = Input::get('translate_for');
        $translation->page = Input::get("page");
        if (empty(Input::get('id'))) {
            Session::flash("msg", "Translation added successfully.");
            $data = ['status' => "1", "message" => "Translation added successfully."];
        } else {
            $data = ['status' => "1", "message" => "Translation updated successfully."];
            Session::flash("msg", "Translation updated successfully.");
        }
        $viewname = '';

        $translation->save();
        return Helper::returnView($viewname, $data, $url = 'admin.translation.view');
    }

    public function delete() {
        $translation = Translation::find(Input::get("id"));
        $translation->delete();
        Session::flash("message", "Translation deleted successfully.");
        $data = ['status' => "1", "message" => "Translation deleted successfully."];
        $viewname = '';

        return Helper::returnView($viewname, $data, $url = 'admin.translation.view');
    }

}
