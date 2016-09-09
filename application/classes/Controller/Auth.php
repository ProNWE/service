<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @author ProNWE team
 * @copyright Khaydarov Murod
 */

class Controller_Auth extends Dispatch {

    public $template = 'auth/auth';

    protected $model = null;

    function action_index()
    {
    }

    function action_signin()
    {
        $email      = Arr::get($_POST, 'email', '');
        $password   = Arr::get($_POST, 'password', '');

        $this->model = new Model_Auth();

        /**
         * If fields are empty
         */
        if ( empty($email) || empty($password)) {
            $this->redirect('auth/');
        }

        $auth = $this->login($email, $password);

        if (!$auth)
        {
            $this->redirect('auth/');
        }
        else
        {
            $id_user = $this->_session->get('id_user');

            $id = Model_Organizations::getByFields('user_created', $id_user);
            $this->redirect('organization/' . $id);
        }


        $this->auth_render = false;
    }
    
    private function login($email, $password, $remember = FALSE)
    {
        return $this->model->login($email, $password);
    }

    private function action_logout($email)
    {
        return $this->model->logout($email, FALSE);
    }

}

?>