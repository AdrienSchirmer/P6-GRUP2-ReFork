<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAppointment extends Model
{
    //
    protected $fillable = [
        'service_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
    ];
}
