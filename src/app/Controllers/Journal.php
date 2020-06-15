<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\JournalModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Journal extends Controller
{
    public JournalModel $model;

    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->model = new JournalModel();
    }

    public function index()
    {
        $data = [
            'entries' => $this->model->getEntries(),
        ];

        echo view('pages/entries', $data);
    }
    
    public function entry($dateString = null)
    {
        $date = strtotime($dateString);
        $entry = $date ? $this->model->getEntries($date) : null;
     
        if (empty($entry))
        {
            throw new PageNotFoundException('Cannot find a journal entry for '. Date('Y-m-d', $date));
        }

        $data = [
            'entries' => [ $entry ],
        ];

        echo view('pages/entries', $data);
    }
}