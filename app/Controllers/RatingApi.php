<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RatingModel;

class RatingApi extends Controller
{
    public function index()
    {
        // Разрешаем CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
        
        // Получаем параметр page
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 5;
        
        $model = new RatingModel();
        $data = $model->paginate($perPage, 'default', $page);
        $pager = $model->pager;
        
        return $this->response->setJSON([
            'data' => $data,
            'pagination' => [
                'current_page' => $pager->getCurrentPage(),
                'last_page' => $pager->getPageCount(),
                'per_page' => $perPage,
                'total' => $pager->getTotal()
            ]
        ]);
    }
public function store()
{
    // Разрешаем CORS
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Authorization, Content-Type');
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    
    // Проверка авторизации
    $token = $this->request->getHeaderLine('Authorization');
    if (empty($token)) {
        return $this->response->setJSON([
            'error' => 'Не авторизован'
        ])->setStatusCode(401);
    }
    
    if ($this->request->getMethod() === 'POST') {
        // Валидация данных
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'rating' => 'required|numeric|greater_than[0]|less_than[100]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'error' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
        
        // Подготовка данных для модели
        $data = [
            'name' => $this->request->getPost('name'),
            'rating' => (int)$this->request->getPost('rating'),
            'user_id' => 1 // временно, пока нет реального пользователя
        ];
        
        $model = new RatingModel();
        $id = $model->insert($data);
        
        if ($id) {
            return $this->response->setJSON([
                'message' => 'Rating created successfully',
                'id' => $id
            ])->setStatusCode(201);
        } else {
            return $this->response->setJSON([
                'error' => 'Ошибка создания записи'
            ])->setStatusCode(500);
        }
    }
    
    return $this->response->setJSON([
        'error' => 'Метод не разрешён'
    ])->setStatusCode(405);
}
    
}