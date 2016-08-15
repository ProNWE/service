<?php

/**
 * Class Controller_Organizations_Modify
 * @author Pronwe team
 * @copyright Khaydarov Murod
 */

class Controller_Organizations_Modify extends Dispatch
{
    public function before()
    {
        $this->auto_render = false;
        parent::before();
    }

    public function action_add()
    {
        $name       = Arr::get($_POST, 'org_name', '');
        $website    = Arr::get($_POST, 'org_site', '');
        $phone      = Arr::get($_POST, 'org_phone', '');

        if (self::isLogged()) {

            $user       = Model_User::getCurrentUser();
            $user_id    = $user->id;


        } else {

            $user       = Arr::get($_POST, 'org_user', '');
            $email      = Arr::get($_POST, 'email', '');
            $password   = Arr::get($_POST, 'password', '');

            $user_info = explode(' ', $user);
            $user_id = Model_User::new_user($user_info[0], $user_info[1], $user_info[2], $email, $password, $phone);
        }

        $organization = Model_Organizations::new_organization($name, $website, $user_id, $phone);
        $this->redirect('organization/' . $organization->id);
    }
    
}