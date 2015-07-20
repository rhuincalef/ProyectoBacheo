<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "publico";
$route['404_override'] = 'error/error_404';
$route['get(TiposEstado|Niveles|TiposRotura|TiposDeMateriales)'] = 'publico/get$1';
$route['get(Falla|Observaciones|Multimedia|Estado|Estados)/(\d+)'] = 'publico/get$1/$2';

$route['get[^(Falla|Observaciones|Multimedia|Estado|Estados)]'] = 'error/error_404';
$route['login'] = 'publico/login_via_ajax';
$route['logout'] = 'publico/logout';
$route['creacionTipoFalla'] = 'publico/creacionTipoFalla';

$route['get(TiposDeMateriales)'] = 'privado/get$1';
// $route['get(TipoDeMaterial|TipoDeReparacion)/(\d+)'] = 'privado/get$1/$2';
$route['get(TipoMaterial|TipoDeReparacion)/(\d+)'] = 'publico/get$1/$2';

/*{3,6}     Between 3 and 6 of characters, tener en cuenta*/
$route['crearTipoAtributo/(\d+)/([\w]+)/([\w]+)'] = 'publico/crearTipoAtributo/$1/$2/$3';
$route['getCriticidades'] = 'publico/getCriticidades';
$route['getLazyTiposFalla/(\d+)'] = 'publico/getLazyTiposFalla/$1';

// Restringir a los necesarios
$route['get/(TipoReparacion|Criticidad|TipoMaterial)/(\d+)'] = 'publico/get/$1/$2';
$route['getAll/(TipoReparacion|Criticidad|TipoMaterial)'] = 'publico/getAll/$1';
$route['crear/(TipoReparacion|TipoFalla|TipoMaterial|Falla)'] = 'publico/crear/$1';

$route['crearFallaAnonima'] = 'publico/crearFallaAnonima';
$route['getTiposFalla/(\d+)'] = 'publico/getTiposFalla/$1';

$route['getAlly/(TipoMaterial)'] = 'publico/getAlly/$1';
$route['gety/(TipoFalla)/(\d+)'] = 'publico/gety/$1/$2';
/* End of file routes.php */
/* Location: ./application/config/routes.php */

?>