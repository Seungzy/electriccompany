<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    /**
     * Display dashboard with customer accounts list (paginated)
     */
    public function index()
    {
        // Get search keyword if exists
        $keyword = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');

        // Items per page
        $perPage = 10;

        // Apply all selected filters to the same paginated query.
        if ($keyword) {
            $this->customerModel->groupStart()
                ->like('account_number', $keyword)
                ->orLike('customer_name', $keyword)
                ->orLike('email', $keyword)
                ->orLike('phone', $keyword)
                ->groupEnd();
        }

        if ($status) {
            $this->customerModel->where('status', $status);
        }

        if ($type) {
            $this->customerModel->where('connection_type', $type);
        }

        $accounts = $this->customerModel->orderBy('created_at', 'DESC')->paginate($perPage);

        // Get statistics
        $data = [
            'accounts' => $accounts,
            'pager' => $this->customerModel->pager,
            'total_accounts' => $this->customerModel->getTotalAccounts(),
            'active_accounts' => $this->customerModel->getCountByStatus('active'),
            'inactive_accounts' => $this->customerModel->getCountByStatus('inactive'),
            'suspended_accounts' => $this->customerModel->getCountByStatus('suspended'),
            'current_page' => $this->request->getGet('page') ?? 1,
            'search_keyword' => $keyword,
            'filter_status' => $status,
            'filter_type' => $type
        ];

        return view('home/index', $data);
    }

    /**
     * View single account details
     */
    public function viewAccount($id)
    {
        $account = $this->customerModel->find($id);

        if (!$account) {
            return redirect()->to('/')->with('error', 'Account not found');
        }

        $data = [
            'account' => $account
        ];

        return view('home/view_account', $data);
    }
}
