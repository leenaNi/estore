<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Category;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\CatalogImage;
use App\Models\Tax;
use App\Models\Product;
use App\Models\HasTaxes;
use App\Models\Sizechart;
use DB;
use Session;

class BillsController extends Controller {
	public function index() {

         $viewname = Config('constants.adminBillView') . '.index';
         return Helper::returnView($viewname);
    }


}