<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\Controller;

class CommentController extends Controller
{
    public function index()
    {
        $model = new CommentModel();

        $sort_by = $this->request->getGet('sort_by') ?? 'created_at';
        $sort_order = $this->request->getGet('sort_order') ?? 'DESC';

        if (!in_array($sort_by, ['id', 'created_at']) || !in_array($sort_order, ['ASC', 'DESC'])) {
            $sort_by = 'created_at';
            $sort_order = 'DESC';
        }

        $data['comments'] = $model->orderBy($sort_by, $sort_order)->paginate(3);
        $data['pager'] = $model->pager;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        return view('comments', $data);
    }

    public function create()
    {
        $model = new CommentModel();

        $data = [
            'name'  => $this->request->getPost('name'),
            'text'  => $this->request->getPost('text'),
            'email' => $this->request->getPost('email'),
            'created_at' => $this->request->getPost('created_at'),
        ];

        if ($this->validate([
            'name' => 'required|min_length[3]',
            'text' => 'required',
            'email' => 'required|valid_email',
            'created_at' => 'required|valid_date[Y-m-d]', // формат 'YYYY-MM-DD'
        ])) {
            $model->save($data);
            $data['id'] = $model->insertID();

            return view('comment_single', $data); // Возвращает HTML для одного комментария
        } else {
            return $this->response->setStatusCode(400)->setJSON($this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        $model = new CommentModel();
        $model->delete($id);
        return $this->response->setStatusCode(204);
    }
}
