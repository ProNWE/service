<?php

class Model_Response_Event extends  Model_Response_Abstract
{
    protected $_EVENT_CREATE_SUCCESS = array(
        'type' => 'events',
        'code' => '50',
        'message' => 'Мероприяие успешно создано'
    );

    protected $_EVENT_DOES_NOT_EXIST_ERROR = array(
        'type' => 'events',
        'code' => '51',
        'message' => 'Мероприяие не существует. Перезагрузите страницу.'
    );

    protected $_EVENT_UPDATE_SUCCESS = array(
        'type' => 'events',
        'code' => '52',
        'message' => 'Информация о мероприяие успешно изменена'
    );

    protected $_EVENT_PUBLISH_ERROR = array(
        'type' => 'events',
        'code' => '53',
        'message' => 'Мероприяие было опубликовано ранее'
    );

    protected $_EVENT_UNPUBLISH_ERROR = array(
        'type' => 'events',
        'code' => '53',
        'message' => 'Мероприяие было снято с публикации ранее'
    );

    protected $_EVENT_PUBLISH_SUCCESS = array(
        'type' => 'events',
        'code' => '54',
        'message' => 'Мероприяие успешно опубликовано'
    );

    protected $_EVENT_UNPUBLISH_SUCCESS = array(
        'type' => 'events',
        'code' => '54',
        'message' => 'Мероприяие успешно снято с публикации'
    );




    protected $_USER_IS_ALREADY_ASSISTANT_ERROR = array(
        'type' => 'events',
        'code' => '53',
        'message' => 'User is already assistant of event'
    );

    protected $_ACCESS_DENIED_ERROR = array(
        'type' => 'events',
        'code' => '54',
        'message' => 'Access denied'
    );

    protected $_USER_IS_NOT_ASSISTANT_ERROR = array(
        'type' => 'events',
        'code' => '55',
        'message' => 'User is not assistant of event'
    );

    protected $_ADD_ASSISTANT_SUCCESS = array(
        'type' => 'events',
        'code' => '56',
        'message' => 'Assistant added'
    );

    protected $_REMOVE_ASSISTANT_SUCCESS = array(
        'type' => 'events',
        'code' => '57',
        'message' => 'Assistant removed'
    );

    protected $_REJECT_ASSISTANT_SUCCESS = array(
        'type' => 'events',
        'code' => '58',
        'message' => 'Assistant rejected'
    );

    protected $_USER_IS_CREATOR_ERROR = array(
        'type' => 'events',
        'code' => '59',
        'message' => 'User is creator of this event'
    );

    protected $_PUBLISH_RESULTS_SUCCESS = array(
        'type' => 'result',
        'code' => '511',
        'message' => 'Результаты опубликованы'
    );

    protected $_UNPUBLISH_RESULTS_SUCCESS = array(
        'type' => 'result',
        'code' => '512',
        'message' => 'Результаты скрыты'
    );


}