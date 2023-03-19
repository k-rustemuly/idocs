<?php

return [
    'idocs' => [
        'base_url' => 'https://external.integration.api.beta.idocs.kz/api/',
        'version' => '2',
        'routes' => [
            'outbox_docs' => 'external-documents/outbox',
            'inbox_docs' => 'external-documents/inbox',
            'file' => 'ExternalDocuments/{doc_id}/PrintForm',
        ],
        'token' => env('IDOCS_KEY', 'undefined'),
    ],

];
