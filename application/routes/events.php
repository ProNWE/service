<?php defined('SYSPATH') or die('No direct plan access.');

/**
 *
 * Routes for module Events
 * @author NWE team
 * @author Khaydarov Murod
 * @author Khaydarov Murod <murod.haydarov@gmail.com>
 *
 * @copyright Turov Nikolay
 * 
 * @version 0.2.1
 */


/**
 * This route checks website existance. Responces only for XMLHTTP requests
 *
 * @example http://pronwe.ru/events/check/ifmo.ru - returns JSON encoded Boolean responce.
 * @return [Boolean]
 */
Route::set('CHECK_EVENT_WEBSITE', 'events/check/<website>',
    array(
        'website' => $STRING
    ))
    ->defaults(array(
      'controller' => 'Events_Ajax',
      'action'     => 'checkwebsite'
    ));
/**
 * Route for event creation
 *
 * @property String $organizationpage - organization local website (without nwe.ru afterfix)
 */
Route::set('NEW_EVENT', '<organizationpage>/event/new',
    array(
        'organizationpage' => $STRING
    ))
    ->defaults(array(
        'controller' => 'Events_Index',
        'action'     => 'New'
    ));

/**
 * Route works with Database.
 * Validates POST data and inserts.
 * Hasn't properties
 */
Route::set('ADD_EVENT', 'event/add')
    ->defaults(array(
        'controller' => 'Events_Modify',
        'action'     => 'add'
    ));

/**
 * Route for event main page.
 *
 * @property String $organizationpage - organization website (without nwe.ru)
 * @property String $eventpage - events website (without nwe.ru)
 * @property String $action - action in controller
 *
 * @example http://pronwe.ru/ifmo/miss
 */
Route::set('EVENTPAGE_MAIN', '<organizationpage>/<eventpage>(/<action>)',
    array(
        'organizationpage' => $STRING,
        'eventpage' => $STRING,
        'action' => $STRING
    ))
    ->defaults(array(
        'controller' => 'Events_Index',
        'action'     => 'EventPage'
    ));

/**
 * Route for backoffice
 *
 * @property String $organizationpage - organization website (without nwe.ru)
 * @property String $eventpage - event website (without nwe.ru)
 * @property String $section - backoffice section (settings | plan | characters)
 * @property String $action - controller action
 *
 * @property [Function] $callback - this callback defines is route allowed to the section or not
 */
$callback = function(Route $route, $params, Request $request){

    $allowedRoutes = array(

        'settings' => array(
            'manageMain', 'deleteMain'
        ),

        'plan' => array(
            'managePlan', 'deletePlan'
        ),

        'charachters' => array(
            'maangeJudge', 'gfgdfg'
        )
    );

    if (!in_array($params['action'], $allowedRoutes[$params['section']])) {
        return false;
    }
};

Route::set('EVENT_MANAGEMENT', '<organizationpage>/<eventpage>/<section>(/<action>)',
    array(
        'organizationpage' => $STRING,
        'eventpage' => $STRING,
        'section' => 'settings|plan|characters',
        'acrion' => $STRING
    ))
    ->filter($callback)
    ->defaults(array(
        'controller' => 'Events_Index',
        'action'     => 'ControlMain'
    ));

