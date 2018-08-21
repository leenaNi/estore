<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Translation;
use View;
use Session;


class Controller extends BaseController {
  

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
    public function __construct() {
        View::share('langs', $this->getTranslations());
    
    }
    public function getTranslations() {
        $trans = Translation::all();
        return $trans;
    }
    public function getbankid(){
      
        $bankid = (Session::get('bankid'))?Session::get('bankid'):'';
        return $bankid;
    }
    

}
