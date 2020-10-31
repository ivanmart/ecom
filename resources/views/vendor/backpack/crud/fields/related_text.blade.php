<?php
    $field['value'] = isset($entry) && $entry->{$field['entity']} ? $entry->{$field['entity']}->{$field['name']} : '';
?>@include('crud::fields.text')