<?php
/**
 * @author Pronwe team
 * @copyright Khaydarov Murod
 * @version 0.1.2
 */

/**
 * Class Controller_Organizations_Ajax
 */
class Controller_Organizations_Ajax extends Ajax
{
    /**
     * Receives POST data, checks for email existance.
     * @returns [Boolean]
     */
    public function action_checkEmail()
    {
        $email = $this->request->param('email');

        $result = Model_User::isUserExist('email', $email);

        if ($result) {
            echo "true";
        } else {
            echo "false";
        }

    }

    /**
     * Receives POST data and checks website
     * @returns [Boolean]
     */
    public function action_checkWebsite()
    {
        $uri = $this->request->param('uri');

        $result = Model_Organization::getByFieldName('uri', $uri);

        if ($result->id) {
            echo "true";
        } else {
            echo "false";
        }

    }

    /**
     * Deletes organization (makes 'is_removed' flag true)
     */
    public function action_delete()
    {
        $id = $this->request->param('id');
        $org = new Model_Organization($id);

        if (!$org->id) {
            throw new HTTP_Exception_404();
        }

        $org->remove();

        $response = new Model_Response_Organization('ORG_REMOVE_SUCCESS', 'success');

        $this->response->body(@json_encode($response->get_response()));

    }

    /**
     * Reestablishes organization
     * @return [Boolean]
     */
    public function action_reestablish()
    {
        $id = $this->request->param('id');

        $org = new Model_Organization($id);

        $org->reestablish();

        $response = new Model_Response_Organization('ORG_REMOVE_SUCCESS', 'success');

        $this->response->body(@json_encode($response->get_response()));

    }

    public function action_join() {

        $id   = $this->request->param('id');

        $org = new Model_Organization($id);

        if (!$org->id) {

            $response = new Model_Response_Organization('ORGANIZATION_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        if (!$this->user->id) {

            $response = new Model_Response_Auth('AUTHORIZATION_REQUIRED_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        $this->redis->sAdd('votepad.orgs:'.$org->id.':join.requests', $this->user->id);

        $response = new Model_Response_Organization('JOIN_REQUEST_SUCCESS', 'success');

        $this->response->body(@json_encode($response->get_response()));
        return;


    }

    public function action_member() {

        $method = $this->request->param('method');
        $o_id     = $this->request->param('id');
        $u_id     = $this->request->param('userid');

        $this->redis->sRem('votepad.orgs:'.$o_id.':join.requests', $u_id);

        switch($method) {
            case 'add': $this->addMember($o_id, $u_id); break;
            case 'remove': $this->removeMember($o_id, $u_id); break;
            case 'reject': $this->rejectMember($o_id, $u_id); break;
        }



    }

    private function addMember($o_id, $u_id) {

        $user = new Model_User($u_id);
        $org  = new Model_Organization($o_id);

        if (!$user->id) {

            $response = new Model_Response_Auth('USER_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }
        if (!$org->id) {

            $response = new Model_Response_Organization('ORGANIZATION_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        if ($org->isMember($user->id)) {

            $response = new Model_Response_Organization('USER_IS_ALREADY_MEMBER_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        $org->addMember($user->id);

        $response = new Model_Response_Organization('ADD_MEMBER_SUCCESS', 'success');

        $this->response->body(@json_encode($response->get_response()));
        return;

    }

    private function removeMember($o_id, $u_id) {

        $user = new Model_User($u_id);
        $org  = new Model_Organization($o_id);

        if (!$user->id) {

            $response = new Model_Response_Auth('USER_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }
        if (!$org->id) {

            $response = new Model_Response_Organization('ORGANIZATION_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        if (!$org->isMember($user->id)) {

            $response = new Model_Response_Organization('USER_IS_NOT_MEMBER_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        if ($org->isOwner($user->id)) {

            $response = new Model_Response_Organization('USER_IS_OWNER_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        $org->removeMember($user->id);

        $response = new Model_Response_Organization('REMOVE_MEMBER_SUCCESS', 'success');

        $this->response->body(@json_encode($response->get_response()));
        return;

    }

    private function rejectMember($o_id, $u_id) {

        $user = new Model_User($u_id);
        $org  = new Model_Organization($o_id);

        if (!$user->id) {

            $response = new Model_Response_Auth('USER_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }
        if (!$org->id) {

            $response = new Model_Response_Organization('ORGANIZATION_DOES_NOT_EXIST_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }
        
        $response = new Model_Response_Organization('REJECT_MEMBER_SUCCESS', 'success');

        $this->response->body(@json_encode($response->get_response()));
        return;

    }


}
