<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Events_Modify
 * @author
 * @copyright
 */

class Controller_Events_Modify extends Controller {

    public function action_add()
    {
        if ($this->request->method() == Request::POST)
        {
            $event_name         = Arr::get($_POST, 'event_name', '');
            $event_site         = Arr::get($_POST, 'event_site', '');
            $event_description  = Arr::get($_POST, 'event_shortdesc', '');
            $event_start        = Arr::get($_POST, 'eventstart', '');
            $event_end          = Arr::get($_POST, 'eventend', '');
            $event_status       = Arr::get($_POST, 'event_status', '');
            $event_city         = Arr::get($_POST, 'event_city', '');
            $event_email        = Arr::get($_POST, 'event_email', '');
            $event_organization = Arr::get($_POST, 'organization', '');

            $id_organization    = Model_Organizations::getByName($event_organization);

            $result = Model_Events::new_event($id_organization, $event_name, $event_site, $event_description, $event_start, $event_end, $event_status, $event_city);

            if ($result)
            {
                $this->redirect('organization/5');
            }
        }
    }

    function action_addParticipant()
    {
        $id_event = $this->request->param('id');

        $k = 0;
        for($i = 0; $i < count($_POST) / 2; $i++)
        {
            $k++;
            $name           = $_POST['participant_name_'. $k];
            $description    = $_POST['participant_description_'. $k];
            $photo          = $_FILES['participant_photo_'. $k]['name'] ?: 'no-user.png';

            $model_participant = new Model_Participants($id_event, $name, $description, $photo);

            $model_participant->save();

            if ($photo != 'no-user.png') {
                $model_uploader = new Model_Uploader($_FILES['participant_photo_' . $k], 'participant_photo', $k);
                $model_uploader->upload();
            }
        }

        $this->redirect('/events/'. $id_event . '/edit' );
    }

    function action_addStage()
    {
        $id_event = $this->request->param('id');

        $stageNameIndex         = 1;
        $stageDescriptionIndex  = 1;

        foreach($_POST as $item => $value)
        {
            if ($item == 'stage_name_' . $stageNameIndex) {
                $stageName[] = $value;
                $stageNameIndex++;
            }

            if ($item == 'stage_description_' . $stageDescriptionIndex) {
                $stageDescription[] = $value;
                $stageDescriptionIndex ++ ;
            }
        }

        $criteriaNameIndex  = 1;
        $criteriaScoreIndex = 1;

        for($i = 1; $i < $stageNameIndex; $i++)
        {

            $model_stages = new Model_Stages();
            $id_stage = $model_stages->insertStages($stageName[$i - 1], $stageDescription[$i - 1], $id_event);
            $model_stages->block($id_stage);
            
            foreach($_POST as $item => $value)
            {
                $str1 = 'criterion-name_'. $i . '_' . $criteriaNameIndex ;
                $str2 = 'criterion-maxscore_'. $i . '_' . $criteriaScoreIndex;

                if ($item == $str1)
                {
                    $criteriaName[$i]['name'][] = $value;
                    $criteriaNameIndex ++;
                }

                if ($item == $str2)
                {
                    $criteriaScore[$i]['score'][] = $value;
                    $criteriaScoreIndex ++;
                }
            }

            for($j = 1; $j < $criteriaNameIndex; $j++)
                $model_stages->insertCriteria($criteriaName[$i]['name'][$j - 1], $criteriaScore[$i]['score'][$j - 1], $id_stage);

            $criteriaNameIndex  = 1;
            $criteriaScoreIndex = 1;
        }

        $this->redirect('/events/'. $id_event . '/edit' );
    }
}