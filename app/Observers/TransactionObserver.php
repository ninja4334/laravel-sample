<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Listen to the Transaction creating event.
     *
     * @param Transaction $model
     *
     * @return void
     */
    public function creating(Transaction $model)
    {
        $model->created_at = $model->freshTimestamp();
    }
}