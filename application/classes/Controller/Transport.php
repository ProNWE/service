<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @copyright Khaydarov Murod
 * https://github.com/khaydarov
 */

class Controller_Transport extends Dispatch {

    private $transportResponse = array(
        'success' => 0
    );

    private $files  = null;
    private $type   = null;
    private $params = null;

    private $typesAvailable = array(
        Model_Uploader::PROFILE_AVATAR,
        Model_Uploader::PROFILE_BRANDING,
        Model_Uploader::EVENT_BRANDING,
        Model_Uploader::PARTICIPANTS_PHOTO,
        Model_Uploader::TEAM_LOGO
    );

    /** File transport module */
    public function before()
    {
        $this->auto_render = false;
        parent::before();
    }

    public function action_upload()
    {
        $this->files    = Arr::get($_FILES, 'files');
        $this->type     = $this->request->param('type');
        $this->params   = json_decode(Arr::get($_POST, 'params'));

        $file = new Model_Uploader();

        if ( !$this->check() ){
            goto finish;
        }

        $uploadedFile = $file->upload($this->type, $this->files, $this->user->id, $this->params);

        if ( $uploadedFile ) {
            $data = array(
                'url'       => $uploadedFile['filepath'],
                'name'      => $uploadedFile['filename'],
            );
            $response = new Model_Response_Uploader('UPLOADER_FILE_SUCCESS', 'success', $data);
            $this->response->body(@json_encode($response->get_response()));
        } else {
            $response = new Model_Response_Uploader('UPLOADER_FILE_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
        }

        finish:
    }

    /**
     * Make necessary verifications
     * @return Boolean
     */
    private function check()
    {
        if (!$this->user->id) {
            $response = new Model_Response_Uploader('UPLOADER_NO_USER_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        if (!$this->type) {
            $response = new Model_Response_Uploader('UPLOADER_NO_TYPE_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        if ( !in_array($this->type, $this->typesAvailable) ){
            $response = new Model_Response_Uploader('UPLOADER_WRONG_TYPE_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        if (!Upload::size($this->files, '2M')) {
            $response = new Model_Response_Uploader('UPLOADER_FILE_SIZE_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        if (!$this->files){
            $response = new Model_Response_Uploader('UPLOADER_FILE_NOT_TRANSFERRED_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        if (!Upload::not_empty($this->files)){
            $response = new Model_Response_Uploader('UPLOADER_FILE_EMPTY_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        if (!Upload::valid($this->files)){
            $response = new Model_Response_Uploader('UPLOADER_FILE_DAMAGED_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return false;
        }
        return true;
    }
}