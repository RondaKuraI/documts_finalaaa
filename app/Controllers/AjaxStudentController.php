<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AjaxStudentModel;

class AjaxStudentController extends BaseController
{
    public function store()
    {
        $students = new  AjaxStudentModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'course' => $this->request->getPost('course')
        ];
        $students->save($data);
        $data = ['status' => 'Student Inserted Successfully'];
        return $this->response->setJSON($data);
    }

    public function fetch(){
        $students = new AjaxStudentModel();
        $data['students'] = $students->findAll();
        return $this->response->setJSON($data);
    }

    public function view(){
        $students = new AjaxStudentModel();
        $student_id = $this->request->getPost('stud_id');
        $data['students'] = $students->find($student_id);
        return $this->response->setJSON($data);
    }

    public function edit(){
        $students = new AjaxStudentModel();
        $student_id = $this->request->getPost('stud_id');
        $data['students'] = $students->find($student_id);
        return $this->response->setJSON($data);
    }

    public function update(){
        $student = new AjaxStudentModel();
        $student_id = $this->request->getPost('stud_id');
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'course' => $this->request->getPost('course')
        ];
        $student->update($student_id, $data);
        $message = ['status' => 'Student Updated Successfully'];
        return $this->response->setJSON($message);
    }

    public function delete(){
        $student = new AjaxStudentModel();
        $student->delete($this->request->getPost('stud_id'));
        $message = ['status' => 'Student Deleted Successfully'];
        return $this->response->setJSON($message);
    }
}
