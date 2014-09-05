<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Este array de configuración contiene  las reglas para validar los campos de cada uno de los formularios. */
$config=array(
                 'altaBache' => array(
                                    array(
                                            'field' => 'titulo',
                                            'label' => 'Titulo',
                                            'rules' => 'required|alpha_numeric'
                                         )
                                    )
                                    // array(
                                    //         'field' => 'latitud',
                                    //         'label' => 'Latitud',
                                    //         'rules' => ''
                                    //      ),
                                    // array(
                                    //         'field' => 'longitud',
                                    //         'label' => 'Longitud',
                                    //         'rules' => ''
                                    //         // 'rules' => 'required|numeric'
                                    //      ),
                                    // array(
                                    //         'field' => 'descripcion',
                                    //         'label' => 'Descripcion',
                                    //         'rules' => ''
                                    //         // 'rules' => 'alpha_numeric|xss_clean'
                                    //      ),
                                    // array(
                                    //         'field' => 'calle',
                                    //         'label' => 'Calle',
                                    //         'rules' => ''
                                    //         // 'rules' => 'required|xss_clean'
                                    //      ),
                                    // array(
                                    //         'field' => 'altura',
                                    //         'label' => 'Altura',
                                    //         'rules' => ''
                                    //         // 'rules' => 'required|integer|max_length[4]|xss_clean'
                                    //      )
                                    // ),
                 // 'agregarComentario' => array(
                 //                    array(
                 //                            'field' => 'emailaddress',
                 //                            'label' => 'EmailAddress',
                 //                            'rules' => 'required|valid_email'
                 //                         ),
                 //                    array(
                 //                            'field' => 'name',
                 //                            'label' => 'Name',
                 //                            'rules' => 'required|alpha'
                 //                         ),
                 //                    array(
                 //                            'field' => 'title',
                 //                            'label' => 'Title',
                 //                            'rules' => 'required'
                 //                         ),
                 //                    array(
                 //                            'field' => 'message',
                 //                            'label' => 'MessageBody',
                 //                            'rules' => 'required'
                 //                         )
                 //                    )                          
               );
/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */