<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
// require APPPATH . '/libraries/Format.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Surat extends REST_Controller {


    public function index_get()
    {

        $this->isAuth();


        $surat = $this->db->get('tipe_surat')->result_array();


        if($surat){
            $this->response(["status" => "success", "data" => $surat, "message" => "Successfully"], REST_Controller::HTTP_OK);
        }else{
            
            $this->response([
                'status' => "fail",
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
        }

    }


}   