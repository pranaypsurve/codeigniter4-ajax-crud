<?php
namespace App\Models;

use \CodeIgniter\Model;
class Home_m extends Model{

    public function save_user_data($userdata = null){
        $builder = $this->db->table('users');
        $builder->insert($userdata);
        if($this->db->affectedRows() == 1){
            return true;
        }else{
            return false;
        }
    }

    public function getData(){
        $builder = $this->db->table('users');
        $res = $builder->get();
        return $res->getResultArray();
    }

    public function get_ind_data($id){
        $builder = $this->db->table('users');
        $builder->where('id',$id);
        $res = $builder->get();
        return $res->getRowArray();
    }

    public function delete_data($id){
        $builder = $this->db->table('users');
        $builder->where('id',$id);
        if($builder->delete()){
            return true;
        }else{
            return false;
        }
    }
    public function update_data($id , $data){
        $builder = $this->db->table('users');
        $builder->where('id',$id);
        if($builder->update($data)){
            return true;
        }else{
            return false;
        }
    }

}
?>