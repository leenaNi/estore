<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\Section;
use DB;

class CronController extends Controller
{
    public function updateRolewisePermissions(){
        ini_set('max_execution_time', -1);
        $per = $permissions = Permission::pluck('display_name')->toArray();
        $newRoutes = [];
        $i = 0;
        foreach (Route::getRoutes() as $value) {
            if (strpos($value->getPrefix(), "admin") !== false) {
                $displayName = ucwords(strtolower(str_replace(".", " ", str_replace("admin.", "", $value->getName()))));
                if (!in_array($displayName, $per)) {
                    if (!empty($displayName)) {
                        $newRoutes[$i]['dispname'] = $displayName;
                        $newRoutes[$i]['name'] = $value->getName();
                    }
                }
                $i++;
            }
        }
        if (count($newRoutes) > 0) {
            foreach ($newRoutes as $value) {
                $permissions = new Permission();
                $permissions->name = $value['name'];
                $permissions->display_name = $value['dispname'];
                $secID = Section::where("name", "like", "%" . $value['name'] . "%")->first();
                $permissions->section_id = (!empty($value['section_id'])) ? $secID->id : 57;
                $permissions->save();
            }
        }
        $sections = Section::where('status', 1)->get();
        $permissions = Permission::all();
       
        $admin_roles = Role::where('name','admin')->get();
        foreach($admin_roles as $key => $role){
           
            foreach($permissions as $key => $val)
            {
                $perarr[] = $val->id;
            }
            if (!empty($permissions)) {
                foreach ($perarr as $key => $perm_id) {
                    $permission = Permission::find($perm_id);
                    if (!$permission->childPermissions->isEmpty()) {
                        $child_prems = $permission->childPermissions->pluck('id')->toArray();
                        foreach ($child_prems as $val) {
                            $ids[] = $val;
                        }
                    }
                    $ids[] = (int) $perm_id;
                }
            }

            if (!empty($permissions)) {
                $role->perms()->sync($ids);
            }
           
        }

    }
}
