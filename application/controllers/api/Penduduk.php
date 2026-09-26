<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Penduduk extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/M_Penduduk', 'penduduk');
    }

    //MENAMPILKAN DATA PENDUDUK BERDASARKAN ID ATAU KODE DESA
    public function index_get()
    {
        $id = $this->get('id');
        $kd_desa = $this->get('kd_desa');
        if ($id === NULL && $kd_desa === NULL) {
            $penduduk = $this->penduduk->getPenduduk();
        } else {
            $penduduk = $this->penduduk->getPenduduk($id, $kd_desa);
        }

        if ($penduduk) {
            $this->response(
                [
                    'status' => true,
                    'data' => $penduduk,
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No penduduk were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === NULL) {
            $this->response([
                'status' => FALSE,
                'message' => 'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->penduduk->deletePenduduk($id) > 0) {
                //ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id,
                    'message' => 'Deleted..!!'
                ], REST_Controller::HTTP_OK);
            } else {
                //id not found
                $this->response([
                    'status' => FALSE,
                    'message' => 'Id not found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'kd_desa' => $this->post('kd_desa'),
            'nm_penduduk' => $this->post('nm_penduduk'),
            'nik' => $this->post('nik'),
            'no_kk' => $this->post('no_kk'),
            'alamat' => $this->post('alamat'),
            'dusun' => $this->post('dusun'),
            'tempat_lahir' => $this->post('tempat_lahir'),
            'tgl_lahir' => $this->post('tgl_lahir'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
        ];

        if ($this->penduduk->createPenduduk($data) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'New penduduk has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to create new penduduk'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'kd_desa' => $this->put('kd_desa'),
            'nm_penduduk' => $this->put('nm_penduduk'),
            'nik' => $this->put('nik'),
            'no_kk' => $this->put('no_kk'),
            'alamat' => $this->put('alamat'),
            'dusun' => $this->put('dusun'),
            'tempat_lahir' => $this->put('tempat_lahir'),
            'tgl_lahir' => $this->put('tgl_lahir'),
            'jenis_kelamin' => $this->put('jenis_kelamin'),
        ];

        if ($this->penduduk->updatePenduduk($id, $data) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'Penduduk has been updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            //id not found
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to update penduduk'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
