<?php
return [
    'service_manager' => [
        'factories' => [
            \gpersone\V1\Rest\Anagrafiche\AnagraficheResource::class => \gpersone\V1\Rest\Anagrafiche\AnagraficheResourceFactory::class,
            \gpersone\V1\Rest\Ruoli\RuoliResource::class => \gpersone\V1\Rest\Ruoli\RuoliResourceFactory::class,
            \gpersone\V1\Rest\Session\SessionResource::class => \gpersone\V1\Rest\Session\SessionResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'gpersone.rest.anagrafiche' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/anagrafiche[/:anagrafiche_id]',
                    'defaults' => [
                        'controller' => 'gpersone\\V1\\Rest\\Anagrafiche\\Controller',
                    ],
                ],
            ],
            'gpersone.rest.ruoli' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/ruoli[/:ruoli_id]',
                    'defaults' => [
                        'controller' => 'gpersone\\V1\\Rest\\Ruoli\\Controller',
                    ],
                ],
            ],
            'gpersone.rest.session' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/session[/:session_id]',
                    'defaults' => [
                        'controller' => 'gpersone\\V1\\Rest\\Session\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'gpersone.rest.anagrafiche',
            1 => 'gpersone.rest.ruoli',
            2 => 'gpersone.rest.session',
        ],
    ],
    'api-tools-rest' => [
        'gpersone\\V1\\Rest\\Anagrafiche\\Controller' => [
            'listener' => \gpersone\V1\Rest\Anagrafiche\AnagraficheResource::class,
            'route_name' => 'gpersone.rest.anagrafiche',
            'route_identifier_name' => 'anagrafiche_id',
            'collection_name' => 'anagrafiche',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \gpersone\V1\Rest\Anagrafiche\AnagraficheEntity::class,
            'collection_class' => \gpersone\V1\Rest\Anagrafiche\AnagraficheCollection::class,
            'service_name' => 'anagrafiche',
        ],
        'gpersone\\V1\\Rest\\Ruoli\\Controller' => [
            'listener' => \gpersone\V1\Rest\Ruoli\RuoliResource::class,
            'route_name' => 'gpersone.rest.ruoli',
            'route_identifier_name' => 'ruoli_id',
            'collection_name' => 'ruoli',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \gpersone\V1\Rest\Ruoli\RuoliEntity::class,
            'collection_class' => \gpersone\V1\Rest\Ruoli\RuoliCollection::class,
            'service_name' => 'ruoli',
        ],
        'gpersone\\V1\\Rest\\Session\\Controller' => [
            'listener' => \gpersone\V1\Rest\Session\SessionResource::class,
            'route_name' => 'gpersone.rest.session',
            'route_identifier_name' => 'session_id',
            'collection_name' => 'session',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \gpersone\V1\Rest\Session\SessionEntity::class,
            'collection_class' => \gpersone\V1\Rest\Session\SessionCollection::class,
            'service_name' => 'session',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'gpersone\\V1\\Rest\\Anagrafiche\\Controller' => 'HalJson',
            'gpersone\\V1\\Rest\\Ruoli\\Controller' => 'HalJson',
            'gpersone\\V1\\Rest\\Session\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'gpersone\\V1\\Rest\\Anagrafiche\\Controller' => [
                0 => 'application/vnd.gpersone.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'gpersone\\V1\\Rest\\Ruoli\\Controller' => [
                0 => 'application/vnd.gpersone.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'gpersone\\V1\\Rest\\Session\\Controller' => [
                0 => 'application/vnd.gpersone.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'gpersone\\V1\\Rest\\Anagrafiche\\Controller' => [
                0 => 'application/vnd.gpersone.v1+json',
                1 => 'application/json',
            ],
            'gpersone\\V1\\Rest\\Ruoli\\Controller' => [
                0 => 'application/vnd.gpersone.v1+json',
                1 => 'application/json',
            ],
            'gpersone\\V1\\Rest\\Session\\Controller' => [
                0 => 'application/vnd.gpersone.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \gpersone\V1\Rest\Anagrafiche\AnagraficheEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'gpersone.rest.anagrafiche',
                'route_identifier_name' => 'anagrafiche_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \gpersone\V1\Rest\Anagrafiche\AnagraficheCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'gpersone.rest.anagrafiche',
                'route_identifier_name' => 'anagrafiche_id',
                'is_collection' => true,
            ],
            \gpersone\V1\Rest\Ruoli\RuoliEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'gpersone.rest.ruoli',
                'route_identifier_name' => 'ruoli_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \gpersone\V1\Rest\Ruoli\RuoliCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'gpersone.rest.ruoli',
                'route_identifier_name' => 'ruoli_id',
                'is_collection' => true,
            ],
            \gpersone\V1\Rest\Session\SessionEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'gpersone.rest.session',
                'route_identifier_name' => 'session_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \gpersone\V1\Rest\Session\SessionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'gpersone.rest.session',
                'route_identifier_name' => 'session_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools' => [
        'db-connected' => [],
    ],
    'api-tools-content-validation' => [],
    'input_filter_specs' => [
        'gpersone\\V1\\Rest\\Anagrafiche\\Validator' => [
            0 => [
                'name' => 'nome',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'cognome',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 90,
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'sesso',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'nas_luogo',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            4 => [
                'name' => 'nas_regione',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 40,
                        ],
                    ],
                ],
            ],
            5 => [
                'name' => 'nas_prov',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 2,
                        ],
                    ],
                ],
            ],
            6 => [
                'name' => 'nas_cap',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 5,
                        ],
                    ],
                ],
            ],
            7 => [
                'name' => 'data_nascita',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            8 => [
                'name' => 'cod_fiscale',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'Laminas\\ApiTools\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'gpersone',
                            'table' => 'anagrafiche',
                            'field' => 'cod_fiscale',
                        ],
                    ],
                    1 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 16,
                        ],
                    ],
                ],
            ],
            9 => [
                'name' => 'res_luogo',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            10 => [
                'name' => 'res_regione',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 40,
                        ],
                    ],
                ],
            ],
            11 => [
                'name' => 'res_prov',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 2,
                        ],
                    ],
                ],
            ],
            12 => [
                'name' => 'res_cap',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 5,
                        ],
                    ],
                ],
            ],
            13 => [
                'name' => 'indirizzo',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 90,
                        ],
                    ],
                ],
            ],
            14 => [
                'name' => 'telefono',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 15,
                        ],
                    ],
                ],
            ],
            15 => [
                'name' => 'email',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'Laminas\\ApiTools\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'gpersone',
                            'table' => 'anagrafiche',
                            'field' => 'email',
                        ],
                    ],
                    1 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 60,
                        ],
                    ],
                ],
            ],
            16 => [
                'name' => 'pass_email',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            17 => [
                'name' => 'id_ruolo',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\Digits::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'Laminas\\ApiTools\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'gpersone',
                            'table' => 'ruoli',
                            'field' => 'id',
                        ],
                    ],
                ],
            ],
        ],
        'gpersone\\V1\\Rest\\Ruoli\\Validator' => [
            0 => [
                'name' => 'nome',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'Laminas\\ApiTools\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'gpersone',
                            'table' => 'ruoli',
                            'field' => 'nome',
                        ],
                    ],
                    1 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
        ],
        'gpersone\\V1\\Rest\\NucleiFamiliari\\Validator' => [
            0 => [
                'name' => 'nome_nucleo',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'data_creazione',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'gpersone\\V1\\Rest\\RelazioniFamiliari\\Validator' => [
            0 => [
                'name' => 'id_persona',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\Digits::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'Laminas\\ApiTools\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'gpersone',
                            'table' => 'anagrafiche',
                            'field' => 'id',
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'id_nucleo',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\Digits::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'Laminas\\ApiTools\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'gpersone',
                            'table' => 'nuclei_familiari',
                            'field' => 'id',
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'grado_parentela',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'data_creazione',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
    ],
];
