<?php

    use Carbon\Carbon;

    function convertForSync(string $modelClass, array $items, string $pivot = 'pivot') {
        $itemIds = [];

        if ($items) {
            foreach ($items as $key => $item) {
                $i = $modelClass::getByUuid($item['uuid']);
                if (is_object($i)) {
                    if (array_key_exists($pivot, $item)) {
                        $itemIds[$i->id] = $item[$pivot];
                    }
                    else {
                        $itemIds[$i->id] = [];
                    }
                }
            }
        }

        return $itemIds;
    }

    function convertForSyncWithPivotFields(string $modelClass, array $items, array $pivotFields = []) {
        $itemIds = [];

        if ($items) {
            foreach ($items as $key => $item) {
                $model = $modelClass::getByUuid($item['uuid']);
                $pivotArray = [];
                if (is_object($model)) {
                    foreach ($pivotFields as $pivot) {
                        if (array_key_exists($pivot, $item)) {
                            $pivotArray[$pivot] = $item[$pivot];
                        }
                    }
                    $itemIds[$model->id] = $pivotArray;
                }
            }
        }

        return $itemIds;
    }

    function convertRelObjectForSync(string $modelClass, array $items, string $relObject) {
        $itemIds = [];
        if ($items) {
            foreach ($items as $key => $item) {
                $i = $modelClass::getByUuid($item[$relObject]['uuid']);
                unset($item[$relObject]);
                if (is_object($i)) {
                    $itemIds[$i->id] = $item;
                }
            }
        }

        return $itemIds;
    }

    function convertCodeModelsForSync($class, $data) {
        $items = [];
        foreach ($data as $item) {
            if (array_key_exists('uuid', $item) || array_key_exists('name', $item)) {
                array_push($items, $class::GetOrMakeId($item));
            }
        }

        return $items;
    }

    function formatDate($date) {
        $date = new Carbon($date);

        return $date->format('Y-m-d');
    }

    function fromArrayWithUuidToId(string $class, $data) {
        if ($data && array_key_exists('uuid', $data)) {
            $item = $class::getByUuid($data['uuid']);

            return is_object($item) ? $item->id : null;
        }

        return null;
    }

    function objectToArray($data) {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = objectToArray($value);
            }

            return $result;
        }

        return $data;
    }

    // For testing data
    function fetchJsonArray(string $route) {
        $client = new \GuzzleHttp\Client();
        $data = $client->request('GET', $route);

        return objectToArray(json_decode($data->getBody()
                                              ->getContents()));
    }

    function fakeModelArray(string $modelClass) {
        $item = factory($modelClass)
            ->make()
            ->toArray();

        return [
            'data' => $item,
        ];
    }

    function getClassText($class) {
        return str_replace('_', ' ', ucfirst(snake_case(class_basename($class))));
    }

    function getSnakeClassName($class) {
        return snake_case(class_basename($class));
    }

    function client() {
        $tenantUuid = \Illuminate\Support\Facades\DB::getDatabaseName();
        return \App\Models\Client::getByUuid($tenantUuid);
    }
