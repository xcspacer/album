<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Home_model");
    }
    public function index()
    {
        $data["user"] = $this->Home_model->user();
        $data["list"] = $this->Home_model->list();
        $data["title"] = "Home";
        $this->load->view('home/home', $data);
    }
    public function createAlbum()
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        function slugCourse($slug)
        {
            $slug = strtolower(preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($slug)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
            return $slug;
        }
        $data['user'] = $_SESSION["logged_user"]["id"];
        $data['album'] = $this->input->post('album', TRUE);
        $data['slug'] = slugCourse($this->input->post('album', TRUE));
        $data['description'] = $this->input->post('description', TRUE);
        $data['price'] = preg_replace('/[^0-9]/', '', $this->input->post('price', TRUE));
        if (!$this->Home_model->checkSlug($data['slug'])) {
            $pathName = APPPATH . '../assets/album/' . $data['slug'];
            if (!file_exists($pathName)) {
                mkdir($pathName);
            } else {
                $pathName .= time();
                mkdir($pathName);
            }
            $config['upload_path']          = APPPATH . '../assets/album/' . $data['slug'];
            $config['allowed_types']        = 'jpeg|gif|jpg|png';
            $config['encrypt_name']        = TRUE;
            $config['max_size']             = 10000;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->upload->display_errors() . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect(base_url());
            } else {
                $upload_data = $this->upload->data();
                $data['image'] = $upload_data['file_name'];
                $this->Home_model->createAlbum($data);
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Álbum criado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Álbum não criado! O nome do álbum deve ser úncio, altere algo no nome e tente novamente.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url());
        }
    }
    public function updateAlbum($slug = null)
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        $data['user'] = $_SESSION["logged_user"]["id"];
        $data['album'] = $this->input->post('album', TRUE);
        $data['description'] = $this->input->post('description', TRUE);
        $data['price'] = preg_replace('/[^0-9]/', '', $this->input->post('price', TRUE));
        $this->Home_model->updateAlbum($slug, $data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Álbum editado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect(base_url());
    }
    public function updateCover()
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        $slug = $this->input->post('slug', TRUE);
        $currentFile = $this->input->post('currentFile', TRUE);
        $config['upload_path']          = APPPATH . '../assets/album/' . $slug;
        $config['allowed_types']        = 'jpeg|gif|jpg|png';
        $config['encrypt_name']        = TRUE;
        $config['max_size']             = 10000;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->upload->display_errors() . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url());
        } else {
            unlink(APPPATH . "../assets/album/$slug/$currentFile");
            $upload_data = $this->upload->data();
            $data['image'] = $upload_data['file_name'];
            $this->Home_model->updateAlbum($slug, $data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Capa alterada!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url());
        }
    }
    public function deleteAlbum($slug = null)
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        $listGallery = $this->Home_model->listGallery($slug);
        foreach ($listGallery as $listGallery) {
            $this->Home_model->deleteGallery($slug);
        }
        $directory = APPPATH . '../assets/album/' . $slug . '/';
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            $file->isFile() ? unlink($file->getPathname()) : rmdir($file->getPathname());
        }
        rmdir($directory);
        $this->Home_model->deleteAlbum($slug);
        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Álbum apagado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect(base_url());
    }
    public function album($slug = null)
    {
        $listAlbum = $this->Home_model->listAlbum($slug);
        foreach ($listAlbum as $listAlbum) {
            $album = $listAlbum->album;
            $description = $listAlbum->description;
            $price = $listAlbum->price;
        }
        $data["list"] = $this->Home_model->album($slug);
        $data["user"] = $this->Home_model->user();
        $data["title"] = $album;
        $data["slug"] = $slug;
        $data["description"] = $description;
        $data["price"] = $price;
        $this->load->view('home/album', $data);
    }
    public function addGallery($slug = null)
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        $data['user'] = $_SESSION["logged_user"]["id"];
        $data['albumSlug'] = $slug;
        $config['upload_path']          = APPPATH . '../assets/album/' . $slug;
        $config['allowed_types']        = 'jpeg|gif|jpg|png';
        $config['encrypt_name']        = TRUE;
        $config['max_size']             = 10000;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->upload->display_errors() . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('album/' . $slug));
        } else {
            $upload_data = $this->upload->data();
            $data['file'] = $upload_data['file_name'];
            $this->Home_model->addGallery($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Imagem adicionada!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('album/' . $slug));
        }
    }
    public function deleteGallery($id = null)
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        $listFile = $this->Home_model->listFile($id);
        foreach ($listFile as $listFile) {
            $file = $listFile->file;
            $slug = $listFile->albumSlug;
        }
        unlink(APPPATH . "../assets/album/$slug/$file");
        $this->Home_model->deleteFile($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Imagem apagada!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect(base_url('album/' . $slug));
    }
    public function update()
    {
        $user = $this->session->userdata("logged_user");
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Usuário não logado!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        $id = $_SESSION["logged_user"]["id"];
        $data = $_POST;
        $this->Home_model->update($id, $data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">Informações editadas!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect(base_url());
    }
}