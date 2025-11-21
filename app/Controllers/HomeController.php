<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\TranscriptionsModel;

class HomeController extends BaseController {

    /**
     * Index page
     */
    public function index() {
        return $this->renderit('pages/home');
    }

    /**
     * Privacy page
     */
    public function privacy() {
        return $this->renderit('pages/privacy');
    }

    /**
     * Terms page
     */
    public function terms() {
        return $this->renderit('pages/terms');
    }

    /**
     * Data deletion page
     */
    public function dataDeletion() {
        return $this->renderit('pages/data-deletion');
    }

    /**
     * Pricing page
     */
    public function pricing() {
        return $this->renderit('pages/pricing', ['subscriptionPlans' => subscriptionPlans()]);
    }

    /**
     * Contact page
     */
    public function contact() {
        return $this->renderit('pages/contact');
    }

    /**
     * Contact submit
     */
    public function contactSubmit() {
        if (!$this->request->isAJAX() && $this->request->getMethod() !== 'post') {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[255]',
            'subject' => 'required|in_list[general,support,billing,feature,partnership,other]',
            'message' => 'required|min_length[10]|max_length[2000]',
        ]);

        if (!$validation->run($this->request->getPost())) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
        ];

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Thank you for your message. We will get back to you within 24 hours.'
        ]);
    }

    /**
     * Render the page
     * @param string $page
     * @param array $extraData
     * @return void
     */
    public function renderit($page, $extraData = []) {
        $data = [
            'baseUrl' => base_url(),
            'appName' => 'VerbaStream',
            'activeUsers' => (new UsersModel())->getActiveUsersCount(),
            'totalTranscriptions' => (new TranscriptionsModel())->countTranscriptions(),
        ];
        $data = array_merge($data, $extraData);
        echo view('templates/header', $data);
        echo view($page, $data);
        echo view('templates/footer', $data);
        return;
    }
}
?>