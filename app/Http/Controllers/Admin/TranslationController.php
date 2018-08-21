<?php

namespace App\Http\Controllers\Admin;

use App\Models\Translation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class TranslationController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index() {
        $langs = Translation::orderBy("id", "asc");
        $trans = new Translation();
        $columns = $trans->schema();
        $search = Input::get('search');
        if (!empty($search)) {

            if (!empty(Input::get('s_language'))) {
                $langs = $langs->where("english", "like", "%" . Input::get('s_language') . "%");
            }
        
        }
         $langs = $langs->paginate(Config('constants.AdminPaginateNo'));
//       
        return view(Config('constants.AdminPagesMastersTranslation') . ".index", ['langs' => $langs, 'columns' => $columns]);
    }

    public function saveUpdate() {
        $langs = Translation::findOrNew(Input::get('id'));
        $trans = new Translation();
        $columns = $trans->schema(); 
        foreach ($columns as $column) {
            $langs->$column = Input::get($column);
        }  
        if($langs->save()){
            return array('status' => 'success', 'id' => $langs->id);
        }
        return array('status' => 'error');
    }
    public function delete() {
        $langs = Translation::find(Input::get('id'));        
        if($langs->delete()){
            return array('status' => 'success');
        }
        return array('status' => 'error');
    }

    public function insert() {
        $lang = new Translation;
        $lang->english = "Home";
        $lang->english = "Home";
        $lang->english = "Home";
        $lang->save();

        return $lang;
    }

}
