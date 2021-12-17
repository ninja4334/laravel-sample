<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class TransactionRepository extends BaseRepository implements TransactionRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Transaction::class;
    }

    /**
     * Create a new entity.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $attributes = array_only($attributes, [
            'board_id',
            'user_id',
            'entity_id',
            'entity_type',
            'amount',
            'status',
            'description',
            'metadata'
        ]);

        $model = $this->model->newInstance();
        $model->forceFill($attributes);
        $model->save();

        return $model;
    }
}
