<?php

namespace App\Controllers;
use App\Models\Home_m;
class Home extends BaseController
{
    protected $home_model;
    public function __construct(){
        helper('form');
        $this->home_model = new Home_m();
    }
    public function index()
    {
        $data['allData'] = $this->home_model->getData();   
        return view('crud_v',$data);
    }
    public function insert(){
        // var_dump($_POST);
        if(isset($_POST['id'])){
            $userData = [
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'city' => $_POST['city']
            ];
            $this->home_model->update_data($_POST['id'],$userData);
            return true;
        }else{
            $userData = [
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'city' => $_POST['city']
            ];
            if($this->home_model->save_user_data($userData)){
                echo json_encode('true');
            }else{
                echo json_encode('false');
            }   
        }
    }
    public function getData(){
        $allData_ajax = $this->home_model->getData();
        echo json_encode($allData_ajax);
    }
    public function edit($id = null){
        // var_dump($id); 
        // if($this->home_model->get_ind_data($id)){
        //     return true;
        // }else{
        //     return false;
        // }
        echo json_encode($this->home_model->get_ind_data($id));
    }
    public function delete($id = null){
        // var_dump($id); 
        if($this->home_model->delete_data($id)){
            return true;
        }else{
            return false;
        }
    }
}
