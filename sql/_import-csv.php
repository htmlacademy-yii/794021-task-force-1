<?php
use R794021\DataFile\{
    CSVImporter, DataTable, SQLInsertMaker
};

require_once './vendor/autoload.php';

const DATABASE = '794021_taskforce';
const CITIES_COUNT = 1108;
const STATE_ID_COUNT = 2;
const USERS_COUNT = 20;
const TASK_CATEGORY_COUNT = 8;
const TASKS_COUNT = 10;

const SETTINGS = [
    'data/categories.csv' => [
        'output' => 'sql/1_category.sql',
        'table' => 'task_category',
        'fieldsMap' => [
            'name' => 'title',
        ],
        'fakeItems' => [],
    ],
    'data/cities.csv' => [
        'output' => 'sql/2_city.sql',
        'table' => 'city',
        'fieldsMap' => [
            'city' => 'name',
            'lat' => 'latitude',
            'long' => 'longitude',
        ],
        'fakeItems' => [],
    ],
    'data/users.csv' => [
        'output' => 'sql/3_user.sql',
        'table' => 'user',
        'fieldsMap' => [
            'name' => 'fullname',
            'password' => 'password_hash',
            'dt_add' => 'datetime_created',
        ],
        'fakeItems' => [
            'city_id' => CITIES_COUNT,
        ],
    ],
    'data/_state.csv' => [
        'output' => 'sql/4_state.sql',
        'table' => 'task_state',
        'fieldsMap' => [],
        'fakeItems' => [],
    ],
    'data/tasks.csv' => [
        'output' => 'sql/5_task.sql',
        'table' => 'task',
        'fieldsMap' => [
            'dt_add' => 'datetime_created',
            'description' => 'text',
            'expire' => 'due_date',
            'name' => 'title',
            'lat' => 'latitude',
            'long' => 'longitude',
        ],
        'fakeItems' => [
            'state_id' => STATE_ID_COUNT,
            'customer_id' => USERS_COUNT,
            'category_id' => TASK_CATEGORY_COUNT,
        ],
    ],
    'data/replies.csv' => [
        'output' => 'sql/6_reply.sql',
        'table' => 'contractor_application',
        'fieldsMap' => [
            'dt_add' => 'datetime_created',
            'description' => 'text',
            'rate' => 'budget',
        ],
        'fakeItems' => [
            'task_id' => TASKS_COUNT,
            'applicant_id' => USERS_COUNT,
        ],
    ],
    'data/_occupation.csv' => [
        'output' => 'sql/7_occupation.sql',
        'table' => 'contractor_occupation',
        'fieldsMap' => [],
        'fakeItems' => [
            'occupation_id' => TASK_CATEGORY_COUNT,
        ],
    ],
    'data/_favorite.csv' => [
        'output' => 'sql/8_favorite.sql',
        'table' => 'favorite_contractor',
        'fieldsMap' => [],
        'fakeItems' => [],
    ],
];

foreach(SETTINGS as $inputFilename => $settings) {
    [
        'output' => $outputFilename,
        'table' => $tableName,
        'fieldsMap' => $fieldsMap,
        'fakeItems' => $fakeItems,
    ] = $settings;
    $importer = new CSVImporter($inputFilename);
    $table = new DataTable($importer->getHeaders(), $importer->getRows());
    $headersMapper = new DataTable(
        $table->getHeaders(),
        $table->getRows()
    );
    $table->renameHeaders($fieldsMap);
    $table->addFakeData($fakeItems);
    $sqlStatement = SQLInsertMaker::make(
        $tableName, $table->getHeaders(), $table->getRows()
    );
    $file = new SplFileObject($outputFilename, 'w');
    $file->fwrite('USE ' . DATABASE . ';' . PHP_EOL);
    $file->fwrite($sqlStatement);
}
