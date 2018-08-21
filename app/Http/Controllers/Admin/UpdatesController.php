<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Document;
use App\Models\Store;
use App\Models\UpdateLog;
use App\Models\Backup;
use Illuminate\Support\Facades\Input;
use Hash;
use File;

class UpdatesController extends Controller {

    public function codeUpdate() {
        $logs = UpdateLog::orderBy('id', 'desc');
        if(Input::get('date_search')){
            $date = explode(' - ',Input::get('date_search'));
            $logs = $logs->whereBetween('date',[$date[0],$date[1]]);
        }
        $logs = $logs->paginate(Config('constants.AdminPaginateNo'));
        return view(Config('constants.AdminPagesUpdatesCode') . ".index", compact('logs'));
    }

    public function backupIndex() {

        $backups = Backup::where('update_log_id', Input::get('id'))->paginate(Config('constants.AdminPaginateNo'));
        return view(Config('constants.AdminPagesUpdatesCode') . ".backupIndex", compact('backups'));
    }

    public function databaseUpdate() {
        return view(Config('constants.AdminPagesUpdatesDB') . ".index");
    }

    public function newCodeUpdate() {
        return view(Config('constants.AdminPagesUpdatesCode') . ".addNew");
    }

    public function save() {
        //dd(Input::all());
        $root = $_SERVER['DOCUMENT_ROOT'] . '/vSwipe';
        $backup = '/storage/store_backup';
        $stores = Store::where("id",18)->get(['url_key'])->toArray();
        
        //dd($stores);
        $update_log = array();
        $backup_log = array();
        $backup_ids = array();
        $no_of_files_updated = 0;
        $temp_upload = $root . '/storage/temp_upload';

        foreach (Input::file('files') as $key => $file) {
            $file_name = $file->getClientOriginalName();
            $file->move($temp_upload, $file_name);
            foreach ($stores as $k => $st) {
                $store = $st['url_key'];
                $path = '/' . $store . Input::get('path')[$key];
                $path = preg_replace('{/$}', '', $path);

                if (File::exists($root . $path . '/' . $file_name)) {
                    if (!File::exists($root . $backup . '/' . $store)) {
                        File::makeDirectory($root . $backup . '/' . $store, 0777, true, true);
                    }
                    if (!File::exists($root . $backup . '/' . $store . '/' . date('Y'))) {
                        File::makeDirectory($root . $backup . '/' . $store . '/' . date('Y'), 0777, true, true);
                    }
                    if (!File::exists($root . $backup . '/' . $store . '/' . date('Y') . '/' . date('m'))) {
                        File::makeDirectory($root . $backup . '/' . $store . '/' . date('Y') . '/' . date('m'), 0777, true, true);
                    }
                    if (!File::exists($root . $backup . '/' . $store . '/' . date('Y') . '/' . date('m') . '/' . date('d'))) {
                        File::makeDirectory($root . $backup . '/' . $store . '/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777, true, true);
                    }
                    ///////////////backup copy
                    $back_filename = time() . '_' . $file_name;
                    $backup_path = $root . $backup . '/' . $store . '/' . date('Y') . '/' . date('m') . '/' . date('d');
                    if (File::copy($root . $path . '/' . $file_name, $backup_path . '/' . $back_filename)) {
                        array_push($backup_log, array('status' => 'Success', 'file' => $backup_path . '/' . $back_filename));
                        $backup_file = new Backup();
                        $backup_file->filename = $back_filename;
                        $backup_file->file_path = $backup_path;
                        $backup_file->source_path = $root . $path;
                        $backup_file->file_relative_path = $backup . '/' . $store . '/' . date('Y') . '/' . date('m') . '/' . date('d');
                        if ($backup_file->save()) {
                            array_push($backup_ids, $backup_file->id);
                        }
                    } else {
                        array_push($backup_log, array('status' => 'Failed', 'file' => $backup_path . '/' . $file_name));
                    }
                    ///////////////update copy
                    if (File::copy($temp_upload . '/' . $file_name, $root . $path . '/' . $file_name)) {
                        $no_of_files_updated++;
                        array_push($update_log, array('status' => 'Success', 'file' => $root . $path . '/' . $file_name));
                    } else {
                        array_push($update_log, array('status' => 'Failed', 'file' => $root . $path . '/' . $file_name));
                    }
                } else {
                    array_push($update_log, array('status' => 'Not Exist', 'file' => $root . $path . '/' . $file_name));
                }
            }
        }
        $update_file_log = new UpdateLog();
        $update_file_log->version = '';
        $update_file_log->date = date('Y-m-d');
        $update_file_log->no_of_files = count(Input::file('files'));
        $update_file_log->no_of_stores = count($stores);
        $update_file_log->no_of_files_updated = $no_of_files_updated;
        $update_file_log->save();
        $backupSynk = Backup::whereIn('id', $backup_ids)->update(['update_log_id' => $update_file_log->id]);
        
        return view(Config('constants.AdminPagesUpdatesCode') . ".status", compact('backup_log', 'update_log'));
    }

    public function saveNew() {
        $root = $_SERVER['DOCUMENT_ROOT'] . '/vSwipe';
        $stores = Store::get(['url_key'])->toArray();
        $update_log = array();
        $backup_log = array();
        $no_of_files_updated = 0;
        $temp_upload = $root . '/storage/temp_upload';

        foreach (Input::file('files') as $key => $file) {
            $file_name = $file->getClientOriginalName();
            $file->move($temp_upload, $file_name);
            foreach ($stores as $k => $st) {
                $store = $st['url_key'];
                $path = '/' . $store . Input::get('path')[$key];
                $path = preg_replace('{/$}', '', $path);
                if (File::exists($root . $path)) {
                    if (!File::exists($root . $path . '/' . $file_name)) {
                        ///////////////update copy

                        if (File::copy($temp_upload . '/' . $file_name, $root . $path . '/' . $file_name)) {
                            $no_of_files_updated++;
                            array_push($update_log, array('status' => 'Success', 'file' => $root . $path . '/' . $file_name));
                        } else {
                            array_push($update_log, array('status' => 'Failed', 'file' => $root . $path . '/' . $file_name));
                        }
                    } else {
                        array_push($update_log, array('status' => 'Already Exist', 'file' => $root . $path . '/' . $file_name));
                    }
                } else {
                    array_push($update_log, array('status' => 'Invalid Directory', 'file' => $root . $path . '/' . $file_name));
                }
            }
        }
        $update_file_log = new UpdateLog();
        $update_file_log->version = '';
        $update_file_log->date = date('Y-m-d');
        $update_file_log->no_of_files = count(Input::file('files'));
        $update_file_log->no_of_stores = count($stores);
        $update_file_log->no_of_files_updated = $no_of_files_updated;
        $update_file_log->save();
        return view(Config('constants.AdminPagesUpdatesCode') . ".status", compact('backup_log', 'update_log'));
    }

    public function newDatabaseUpdate() {
        return view(Config('constants.AdminPagesUpdatesDB') . ".addNew");
    }

}
