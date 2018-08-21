<?php

namespace App\Http\Controllers\Frontend;

use Route;
use Input;
use App\Models\StaticPage;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use Session;
use Illuminate\Http\Request;
use DB;
use Validator;

class StaticPagesController extends Controller {

    public function index() {
        show_404();
    }

    public function showPage(Request $request,$id){
        $page = StaticPage::find($id);
        $data = ['description' => $page->description];
        $viewname = Config('constants.frontendStaticPageView') . '.index';
        return Helper::returnView($viewname, $data);
    }
}
