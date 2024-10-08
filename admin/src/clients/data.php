<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/errorDisplay.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    
    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'clients',
        'api-table-name' => 'clients',
        'id-column-name' => 'client_id',
        'form-data' => [
            'name' => [
                'api-col' => 'name',
                'title' => 'Vārds/Nosaukums',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Kategorijas nosaukums ir nepieciešams'
                ],
                'required' => true
            ],
            'email' => [
                'api-col' => 'email',
                'title' => 'E-pasts',
                'value' => null,
                'type' => FormDataType::EMAIL,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => FormTypeErrorConditions::getEmailConditions(),
                'required' => true
            ],
            'phone_number' => [
                'api-col' => 'phone_number',
                'title' => 'Telefona numurs',
                'value' => null,
                'type' => FormDataType::PHONE_NUMBER,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => FormTypeErrorConditions::getPhoneNumberConditions(),
                'required' => true
            ],
            'adress' => [
                'api-col' => 'address',
                'title' => 'Adrese',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Adrese ir nepieciešama'
                ],
                'required' => true
            ],
        ]
    ];
?>