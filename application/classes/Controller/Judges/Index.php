<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Khaydarov Murod
 */


class Controller_Judges_Index extends Dispatch {

    
    public $template = 'judges/main';
    
     /**
     * action_votingpanel
     */
    public function action_votingpanel()
    {
        $this->template->header = View::factory('judges/blocks/header');
        $this->template->jumbotron_wrapper = View::factory('judges/blocks/jumbotron_wrapper');
        $this->template->main_section = View::factory('judges/panel/tmp');
    }

    
}

?>