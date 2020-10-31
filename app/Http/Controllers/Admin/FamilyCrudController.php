<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\FamilyRequest as StoreRequest;
use App\Http\Requests\FamilyRequest as UpdateRequest;

class FamilyCrudController extends CrudController
{

    public function setup()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Family");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/product-family');
        $this->crud->setEntityNameStrings('product family', 'product families');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

//        $this->crud->setFromDb();
        // $this->crud->allowAccess('reorder');
        // $this->crud->enableReorder('name', 1);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([    // CHECKBOX
            'name' => 'visible',
            'label' => 'Visible Family',
            'type' => 'checkbox',
        ]);
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
        ]);

        $this->crud->enableAjaxTable();
    }
        
	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
