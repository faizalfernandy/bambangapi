<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

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
class Auth extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }


    public function login_post()
    {
        $no_telp = $this->post('no_telp');
        $password = $this->post('password');


        if($no_telp == ''){
            $this->response([
                'status' => FALSE,
                'message' => 'No Telepon is required!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else if($password == ''){
            $this->response([
                'status' => FALSE,
                'message' => 'Password required!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        

        $user = $this->db->get_where('users', ['nomor_telepon' => $no_telp, 'password' => md5($password)])->row_array();

        if($user){
            
            $user['key'] = uniqid();
            $this->session->set_userdata('userdata', $user);
            $this->set_response([
                'status' => 'success',
                'data' => $user,
                'message' => 'is_loggedIn'
            ], REST_Controller::HTTP_OK);
            
        }else{
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

        
    }

    // public function register_post()
    // {
    //     $no_telp = $this->post('no_telp');
    //     $password = $this->post('password');

    //     if($no_telp == ''){
    //         $this->response([
    //             'status' => FALSE,
    //             'message' => 'No Telepon is required!'
    //         ], REST_Controller::HTTP_BAD_REQUEST);
    //     }else if($password == ''){
    //         $this->response([
    //             'status' => FALSE,
    //             'message' => 'Password required!'
    //         ], REST_Controller::HTTP_BAD_REQUEST);
    //     }

        
    // }


}