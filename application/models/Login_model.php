<?php
class Login_model extends CI_Model
{
    public function access($email, $password)
    {
        $this->db->where("email", $email);
        $this->db->where("password", $password);
        $user = $this->db->get("user")->row_array();
        return $user;
    }
    public function userAccess($user)
    {
        $this->db->insert("userAccess", $user);
        return $this->db->insert_id();
    }
    public function userRefused($user)
    {
        $this->db->insert("userRefused", $user);
        return $this->db->insert_id();
    }
    public function checkEmail($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('user')->row_array();
    }
    public function newHash($email, $hash)
    {
        $this->db->where('email', $email);
        $this->db->update('user', array('rememberToken' => $hash));
    }
    public function getHash($hash)
    {
        $this->db->where('rememberToken', $hash);
        return $this->db->get('user')->result();
    }
    public function newPassword($id, $password)
    {
        $this->db->where('id', $id);
        $this->db->update('user', array('password' => $password));
    }
    public function deleteHash($id)
    {
        $this->db->where('id', $id);
        $this->db->update('user', array('rememberToken' => null));
    }
}