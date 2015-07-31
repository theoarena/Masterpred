<?php defined('SYSPATH') OR die('No direct access allowed.');

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {
 
    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     * 
     * @return Response
     */
    public function get_response()
    {
        $view = View::factory('avisos/404'); 
 
        $response = Response::factory()
            ->status(404)
            ->body($view->render());
 
        return $response;
    }
}