<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Dashboard extends BaseController
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

    public function newAccount()
    {
        return view('home/account_form', ['account' => null, 'errors' => session()->getFlashdata('errors') ?? []]);
    }

    public function createAccount()
    {
        if (!$this->validate($this->accountRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!$this->customerModel->insert($this->accountData())) {
            return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        }

        return redirect()->to('/dashboard')->with('success', 'Customer account created.');
    }

    public function editAccount($id)
    {
        $account = $this->customerModel->find($id);
        if (!$account) {
            return redirect()->to('/dashboard')->with('error', 'Account not found.');
        }

        return view('home/account_form', ['account' => $account, 'errors' => session()->getFlashdata('errors') ?? []]);
    }

    public function updateAccount($id)
    {
        if (!$this->customerModel->find($id)) {
            return redirect()->to('/dashboard')->with('error', 'Account not found.');
        }
        if (!$this->validate($this->accountRules($id))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!$this->customerModel->update($id, $this->accountData())) {
            return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        }

        return redirect()->to('/account/' . $id)->with('success', 'Customer account updated.');
    }

    public function deleteAccount($id)
    {
        if (!$this->customerModel->find($id)) {
            return redirect()->to('/dashboard')->with('error', 'Account not found.');
        }

        $this->customerModel->delete($id);
        return redirect()->to('/dashboard')->with('success', 'Customer account deleted.');
    }

    private function accountRules(?int $id = null): array
    {
        $uniqueAccount = 'is_unique[customer_accounts.account_number' . ($id ? ',id,' . $id : '') . ']';
        return [
            'account_number' => 'required|max_length[50]|' . $uniqueAccount,
            'customer_name' => 'required|max_length[150]',
            'address' => 'required',
            'phone' => 'permit_empty|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'meter_number' => 'permit_empty|max_length[50]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status' => 'required|in_list[active,inactive,suspended]',
        ];
    }

    private function accountData(): array
    {
        $fields = ['account_number', 'customer_name', 'address', 'phone', 'email', 'meter_number', 'connection_type', 'status'];
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = trim((string) $this->request->getPost($field));
        }
        return $data;
    }

    /**
     * View single account details
     */
    public function viewAccount($id)
    {
        $account = $this->customerModel->find($id);

        if (!$account) {
            return redirect()->to('/dashboard')->with('error', 'Account not found.');
        }

        $data = [
            'account' => $account
        ];

        return view('home/view_account', $data);
    }
}
