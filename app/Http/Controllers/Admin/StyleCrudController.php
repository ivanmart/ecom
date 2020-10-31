<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StyleRequest as StoreRequest;
use App\Http\Requests\StyleRequest as UpdateRequest;

class StyleCrudController extends CrudController
{

    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Style');
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/product-style');
        $this->crud->setEntityNameStrings('product style', 'product styles');
        $this->crud->addClause('withoutGlobalScopes');
        $this->crud->model->clearGlobalScopes();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // $this->crud->setFromDb();

        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 1);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        $this->crud->addColumn([
            'name' => 'slug',
            'label' => 'Slug',
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([    // CHECKBOX
            'name' => 'visible',
            'label' => 'Visible',
            'type' => 'checkbox',
        ]);
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your name, if left empty.',
            // 'disabled' => 'disabled'
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'placeholder' => 'Description text here',
        ]);
        $this->crud->addField([
            'name' => 'template',
            'label' => 'Шаблон',
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'Изображение',
            'type' => 'image',
            'upload' => true,
        ]);

        $this->crud->addField([
            'name' => 'background',
            'label' => 'Фоновое изображение',
            'type' => 'image',
            'upload' => true,
        ]);


        $this->crud->enableAjaxTable();

    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
