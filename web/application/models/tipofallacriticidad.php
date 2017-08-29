<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class TipoFallaCriticidad
    {
        
        var $idTipoFalla;
        var $idCriticidad;
        
        function __construct()
        {
            
        }

        public static function obtenerCriticidadesAsociadas($idTipoFalla){
            $CI = &get_instance();
            $criticidades =  $CI->TipoFallaCriticidadModelo->getCriticidadesAsociadas($idTipoFalla);
            $colCriticidades = array();
            foreach ($criticidades as $row) {
                log_message('debug','La criticidad del row es -->');
                log_message('debug',$row->idCriticidad);
                $criticidad = Criticidad::getInstancia($row->idCriticidad);
                array_push($colCriticidades, $criticidad);
            }
            log_message('debug','Obtenidas criticidades');
            return $colCriticidades;
        }

    }
