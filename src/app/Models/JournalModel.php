<?php namespace App\Models;

use CodeIgniter\Model;

class JournalModel extends Model
{
    protected $table = 'entries';
    protected $allowedFields = ['date', 'description', 'body'];

    public function getEntries($take, $skip = 0)
    {
        return $this->orderBy('date DESC')->findAll($take, $skip);
    }

    public function getEntry($date)
    {
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

    public function getDaysWithEntryForMonth($year, $month) {
        $startDate = Date('Y-m-d', strtotime($month.'/1/'.$year));
        $sql = 'SELECT DAY(`date`) as day
            FROM entries
            WHERE `date` >= ?
            AND `date` < DATE_ADD(?, INTERVAL 1 MONTH);';

        $resultArray = $this->db->query($sql, [$startDate, $startDate])->getResult('array');

        return array_map(function($x) { 
            return intval($x['day']);
        }, $resultArray);
    }
}