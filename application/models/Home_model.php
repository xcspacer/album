<?php
class Home_model extends CI_Model
{
    public function user()
    {
        return $this->db->get("user")->result_array();
    }
    public function update($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("user", $data);
    }
    public function list()
    {
        return $this->db->get("album")->result_array();
    }
    public function checkSlug($slug)
    {
        $this->db->where('slug', $slug);
        return $this->db->get('album')->row_array();
    }
    public function createAlbum($data)
    {
        $this->db->insert("album", $data);
        return $this->db->insert_id();
    }
    public function updateAlbum($slug, $data)
    {
        $this->db->where("slug", $slug);
        return $this->db->update("album", $data);
    }
    function listGallery($slug, $options = array())
    {
        $this->db->where('albumSlug', $slug);
        $query = $this->db->get('gallery');
        if (isset($options['idGallery']))
            return $query->row(0);
        return $query->result();
    }
    public function deleteGallery($slug)
    {
        $this->db->where("albumSlug", $slug);
        return $this->db->delete("gallery");
    }
    public function deleteAlbum($slug)
    {
        $this->db->where("slug", $slug);
        return $this->db->delete("album");
    }
    public function album($slug)
    {
        $query = "SELECT * FROM album INNER JOIN gallery ON gallery.albumSlug = album.slug WHERE album.slug = '$slug'";
        $result = $this->db->query($query);
        return  $result->result_array();
    }
    function listAlbum($slug, $options = array())
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('album');
        if (isset($options['idAlbum']))
            return $query->row(0);
        return $query->result();
    }
    public function addGallery($data)
    {
        $this->db->insert("gallery", $data);
        return $this->db->insert_id();
    }
    function listFile($id, $options = array())
    {
        $this->db->where('idGallery', $id);
        $query = $this->db->get('gallery');
        if (isset($options['idGallery']))
            return $query->row(0);
        return $query->result();
    }
    public function deleteFile($id)
    {
        $this->db->where("idGallery", $id);
        return $this->db->delete("gallery");
    }
}