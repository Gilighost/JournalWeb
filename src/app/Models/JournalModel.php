<?php namespace App\Models;

use CodeIgniter\Model;

class JournalModel extends Model
{
    protected $table = 'entries';
    protected $allowedFields = ['title', 'slug', 'body'];

    public function getEntries($date = null)
    {
        if (is_null($date))
        {
            return $this->orderBy('date DESC')->findAll();
        }

        return $this
            ->where('date', Date('Y-m-d', $date))
            ->orderBy('date DESC')
            ->first();
    }
}