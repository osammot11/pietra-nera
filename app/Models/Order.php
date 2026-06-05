<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = []; // Permette il mass assignment su tutti i campi

    // Un ordine ha molti biglietti
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}