<?php

namespace App\Traits;

// This trait overwrites two methods from vendor's trait to support 1-1 relation and its n-1 sub-relations:

trait BackpackCrudCreate
{
    /*
    |--------------------------------------------------------------------------
    |                                   CREATE
    |--------------------------------------------------------------------------
    */

    public function create($data)
    {
        $data = $this->decodeJsonCastedAttributes($data, 'create');
        $data = $this->compactFakeFields($data, 'create');

        // ommit all the relationships when updating the eloquent item
        $relationships = array_pluck($this->getRelationFieldsWithPivotOrRelated('create'), 'name');
        $item = $this->model->create(array_except($data, $relationships));

        // if there are any relationships available, also sync those
        $this->syncPivot($item, $data);

        return $item;
    }

    public function update($id, $data)
    {
        $data = $this->decodeJsonCastedAttributes($data, 'update', $id);
        $data = $this->compactFakeFields($data, 'update', $id);

        $item = $this->model->findOrFail($id);

        $this->syncPivot($item, $data, 'update');

        // ommit the n-n relationships when updating the eloquent item
        $relationships = array_pluck($this->getRelationFieldsWithPivotOrRelated('update'), 'name');
        $data = array_except($data, $relationships);
        $updated = $item->update($data);

        return $item;
    }

    public function getRelationFieldsWithPivotOrRelated($form = "create") {
        $all_relation_fields = $this->getRelationFields($form);

        return array_where($all_relation_fields, function ($value, $key) {
            return strpos($value["type"], "related_") === 0 || (isset($value['pivot']) && $value['pivot']);
        });
    }

    public function getRelationFields($form = "create")
    {
        if ($form == "create") {
            $fields = $this->create_fields;
        } else {
            $fields = $this->update_fields;
        }

        $relationFields = [];

        foreach ($fields as $field) {
            if (isset($field["model"])) {
                array_push($relationFields, $field);
            } else

            if (isset($field["subfields"]) &&
                is_array($field["subfields"]) &&
                count($field["subfields"])) {
                foreach ($field["subfields"] as $subfield) {
                    array_push($relationFields, $subfield);
                }
            } else

            if (isset($field["type"]) &&
                strpos($field["type"], "related_") === 0) {
                array_push($relationFields, $field);
            }
        }

        return $relationFields;
    }

    public function syncPivot($model, $data, $form = "create")
    {
        $fields_with_relationships = $this->getRelationFields($form);

        foreach ($fields_with_relationships as $key => $field) {
            if (isset($field["pivot"]) && $field["pivot"]) {
                $values = isset($data[$field["name"]]) ? $data[$field["name"]] : [];
                $model->{$field["name"]}()->sync($values);

                if (isset($field["pivotFields"])) {
                    foreach ($field["pivotFields"] as $pivotField) {
                        foreach ($data[$pivotField] as $pivot_id => $field) {
                            $model->{$field["name"]}()->updateExistingPivot($pivot_id, [$pivotField => $field]);
                        }
                    }
                }
            }

            if (isset($field["morph"]) && $field["morph"]) {
                $values = isset($data[$field["name"]]) ? $data[$field["name"]] : [];
                if ($model->{$field["name"]}) {
                    $model->{$field["name"]}()->update($values);
                } else {
                    $model->{$field["name"]}()->create($values);
                }
            }
            if(strpos($field["type"], "related_") === 0 && isset($data[$field["name"]])) {
                $value = $data[$field["name"]];
                if (is_null($model->{$field["entity"]})) {
                    $newModel[$field["name"]] = $value;
                } else {
                    $model->{$field["entity"]}->{$field["name"]} = $value;
                    $model->{$field["entity"]}->save();
                }
            }
        }

        if(isset($newModel))
            $model->{$field["entity"]}()->create($newModel);

    }
}
