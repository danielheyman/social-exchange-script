<?php
//Arrays to store user-registered events and functions.
$action_events = array();
$filter_events = array();

//Functions for Action Hooks
function hook_action($event)
{
    global $action_events;
 
    if(isset($action_events[$event]))
    {
        foreach($action_events[$event] as $func)
        {
            if(!function_exists($func)) {
                die('Unknown function: '.$func);
            }
                call_user_func($func);//, $args);
            }
    }
 
}

function register_action($event, $func)
{
    global $action_events;
    $action_events[$event][] = $func;
}

//Functions for Filter Hooks
function hook_filter($event,$content) {
 
    global $filter_events;
 
    if(isset($filter_events[$event]))
    {
        foreach($filter_events[$event] as $func) {
            if(!function_exists($func)) {
                die('Unknown function: '.$func);
            }
          $content = call_user_func($func,$content);
        }
    }
    return $content;
}

function register_filter($event, $func)
{
    global $filter_events;
    $filter_events[$event][] = $func;
}

?>