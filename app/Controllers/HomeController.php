<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController {

    /**
     * Index page
     */
    public function index() {
        return $this->renderit('pages/home');
    }

    public function privacy() {
        return $this->renderit('pages/privacy');
    }

    public function terms() {
        return $this->renderit('pages/terms');
    }

    public function dataDeletion() {
        return $this->renderit('pages/data-deletion');
    }

    /**
     * Render the page
     * @param string $page
     * @return void
     */
    public function renderit($page) {
        $data = [
            'baseUrl' => base_url(),
            'appName' => 'MobileTranscribe.com',
        ];
        echo view('templates/header', $data);
        echo view($page, $data);
        echo view('templates/footer', $data);
        return;
    }
}
?>