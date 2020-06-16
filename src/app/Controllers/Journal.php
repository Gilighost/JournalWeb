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
            'isDateEntry' => false,
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
            'isDateEntry' => true,
        ];

        echo view('pages/entries', $data);
    }

    public function getWrite($dateString = null)
    {
        $date = strtotime($dateString);
        if(!$date) 
        {
            return redirect()->to('/write/' . Date('Y-m-d'));
        }

        $entry = $this->model->getEntries($date);

        $data = [
            'entry' => (empty($entry)
                ? ['date' => Date('Y-m-d', $date)]
                : $entry)
        ];

        echo view('pages/write', $data);

    }

    public function postWrite($dateString = null)
    {
        $date = strtotime($dateString);
        if(!$date)
        {
            return $this->$response->setStatusCode(400, 'Invalid date.');
        }

        if (!$this->validate([
            'description' => 'required|max_length[250]',
        ]))
        {
            $data = [
                'errors' => $this->validator->getErrors(),
                'entry' => [
                    'date' => Date('Y-m-d', $date),
                    'description' => $this->request->getVar('description'),
                    'body'  => $this->request->getVar('body'),
                ],
            ];

            echo view('pages/write', $data);
        }
        else
        {
            $data = [
                'date' => $dateString,
                'description' => $this->request->getVar('description'),
                'body'  => $this->request->getVar('body'),
            ];

            $this->model->write($data);

            return redirect()->to('/');
        }
    }

    public function getEntryDays($year, $month)
    {
        if(intval($month) > 12 || intval($month) < 1)
        {
            return $this->$response->setStatusCode(400, 'Invalid month.');
        }

        $days = $this->model->getDaysWithEntryForMonth($year, $month);

        return $this->response->setJSON($days);
    }
}