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

    public function write($data)
    {
        if (empty($data) || empty($data['date']) || empty($data['description']))
        { 
            throw new InvalidArgumentException('data must have \'date\' and \'description\' keys.');
        }

        $allowedKeys  = ['date', 'description', 'body'];
        $filteredData = array_filter(
            $data,
            function ($key) use ($allowedKeys) {
                return in_array($key, $allowedKeys);
            },
            ARRAY_FILTER_USE_KEY
        );
     
        $escapedData = array_map(function($d) {
            return $this->db->escape($d);
        }, $filteredData);

        $bodySql = !empty($escapedData['body']) ? ['insert' => ', body', 'update' => ', body = '.$escapedData['body']] : ['', ''];
        $sql = 'INSERT INTO `entries` (date, description'.$bodySql['insert'].') 
            VALUES('.join(',', $escapedData).')
            ON DUPLICATE KEY UPDATE
            description = '.$escapedData['description']
            .$bodySql['update'].';';

        $this->db->query($sql);
    }
}