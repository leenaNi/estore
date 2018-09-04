<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelOrder extends Model {

    //
    protected $connection = 'mysql2';
    protected $table = "order_cancelled";

    public function getorders() {
        return $this->belongsTo("App\Models\Order", "order_id");
    }

    public function reason() {
        return $this->belongsTo("App\Models\OrderReturnReason", "reason_id");
    }

}
