<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
//use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;


// Need to overwrite methods in Backpack's CRUD Create and Update traits, to support 1-1 relation and its n-1 sub-relations save/update:

use Backpack\CRUD\PanelTraits\Create; // base trait
use Backpack\CRUD\PanelTraits\Update; // base trait
use App\Traits\BackpackCrudCreate; // overwritten methods

class CrudPanel extends \Backpack\CRUD\CrudPanel 
{
    use Create, Update, BackpackCrudCreate 
    {
        BackpackCrudCreate::update insteadof Update;
        BackpackCrudCreate::create insteadof Create;
        BackpackCrudCreate::getRelationFields insteadof Create;
        BackpackCrudCreate::syncPivot insteadof Create;
    }
}

class CrudController extends \Backpack\CRUD\app\Http\Controllers\CrudController
{

    public function __construct()
    {
        if (! $this->crud) {
            $this->crud = app()->make(CrudPanel::class);
            $this->crud->enableExportButtons();

            // call the setup function inside this closure to also have the request there
            // this way, developers can use things stored in session (auth variables, etc)
            $this->middleware(function ($request, $next) {
                $this->request = $request;
                $this->crud->request = $request;
                $this->setup();

                return $next($request);
            });
        }
    }

}

class ProductCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/product-item');
        $this->crud->setEntityNameStrings('product', 'products');
        $this->crud->addClause('withoutGlobalScopes');
        $this->crud->model->clearGlobalScopes();

        /*
		|--------------------------------------------------------------------------
		| COLUMNS
		|--------------------------------------------------------------------------
		*/

//        $this->crud->setFromDb();
        // $this->crud->allowAccess('reorder');
        // $this->crud->enableReorder('name', 1);

        $this->crud->enableAjaxTable();

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        $this->crud->addColumn([
            'name' => 'slug',
            'label' => 'Slug',
        ]);

        $this->crud->addColumn([    // SELECT
            'label' => 'Brand',
            'type' => 'select',
            'name' => 'brand_id',
            'entity' => 'brand',
            'attribute' => 'name',
            'model' => 'App\Models\Brand',
        ]);

        $this->crud->addColumn([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => 'Categories',
            'type' => 'select_multiple',
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => 'App\Models\Category', // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'price',
            'label' => 'Price',
        ]);

        $this->crud->addColumn([
            'name' => 'old_price',
            'label' => 'Old Price',
        ]);

        $this->crud->addColumn([
            'name' => 'listed',
            'label' => 'Listed',
            'type' => 'check',
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        $this->crud->addFilter([ // simple filter
                'type' => 'simple',
                'name' => 'listed',
                'label'=> 'Listed'
            ], 
            false, 
            function() { // if the filter is active
                $this->crud->addClause('listed'); // apply the "active" eloquent scope 
        });
        
        $this->crud->addFilter([ // select2 filter
                'name' => 'brand_id',
                'type' => 'select2',
                'label'=> 'Brand'
            ], function() {
                return \App\Models\Brand::all()->pluck('name', 'id')->toArray();
            }, function($value) { // if the filter is active
                $this->crud->addClause('where', 'brand_id', $value);
        });        

        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */

        $commonTabName = 'Common';
        $lightsTabName = 'Light attributes';
        $bulbsTabName = 'Bulb attributes';

        $this->crud->addField([    // CHECKBOX
            'name' => 'active',
            'label' => 'Active',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,

        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'listed',
            'label' => 'Listed',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'new',
            'label' => 'New',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'no_update',
            'label' => 'Do Not Update',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'discontinued',
            'label' => 'Discontinued',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'undiscounted',
            'label' => 'Undiscounted',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'view360',
            'label' => 'View 360',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // CHECKBOX
            'name' => 'is_bulb',
            'label' => 'Is Bulb',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // TEXT
            'name' => 'price',
            'label' => 'Price',
            'type' => 'number',
            // optionals
            'prefix' => 'RUB',
//             'suffix' => '.00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // TEXT
            'name' => 'old_price',
            'label' => 'Old Price',
            'type' => 'number',
            // optionals
            'prefix' => 'RUB',
//            'suffix' => '.00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([
            'name' => 'name',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your name, if left empty.',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            // 'disabled' => 'disabled'
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // SELECT
            'label' => 'Brand',
            'type' => 'select2',
            'name' => 'brand_id',
            'entity' => 'brand',
            'attribute' => 'name',
            'model' => 'App\Models\Brand',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'type' => 'select2_multiple',
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => 'App\Models\Category', // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => 'App\Models\Tag', // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // TEXT
            'name' => 'meta_title',
            'label' => 'Meta Title',
            'type' => 'text',
            'placeholder' => 'Your meta title here',
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // TEXT
            'name' => 'meta_keywords',
            'label' => 'Meta Keywords',
            'type' => 'text',
            'placeholder' => 'Your meta keywords here',
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([   // WYSIWYG
            'name' => 'meta_description',
            'label' => 'Meta Description',
            'type' => 'text',
            'placeholder' => 'Your meta description here',
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([   // WYSIWYG
            'name' => 'description',
            'type' => 'ckeditor',
            'placeholder' => 'Your meta description here',
            'tab' => $commonTabName,
        ]);

        $this->crud->addField([    // Image
            'name' => 'image1dark',
            'label' => 'Изображение для каталога',
            'type' => 'image',
            'upload' => true,
            'tab' => $commonTabName,
        ]);
        
        $this->crud->addField([    // Image
            'name' => 'top_image',
            'label' => 'Изображение в шапке',
            'type' => 'image',
            'upload' => true,
            'tab' => $commonTabName,
        ]);
        
        $this->crud->addField([    // Image
            // Select2Multiple = n-n relationship (with pivot table)
            'label' => 'Images',
            'type' => 'upload_multiple',
            'name' => 'images',
            'entity' => 'images',
            'attribute' => 'filename',
            'model' => 'App\Models\ProductImage',
            'upload' => true,
//            'disk' => 'uploads',
            // 'pivot' => true,
            'tab' => $commonTabName,
        ]);


// ----------- Light's props

        $this->crud->addField([
            'label' => 'Family',
            'type' => 'related_select2',
            'entity' => 'light',
            'name' => 'family_id',
            'model' => '\App\Models\Family',
            'attribute' => 'name',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([
            'label' => 'Style',
            'type' => 'related_select2',
            'entity' => 'light',
            'name' => 'style_id',
            'model' => '\App\Models\Style',
            'attribute' => 'name',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([
            'label' => 'Collection',
            'type' => 'related_select2',
            'entity' => 'light',
            'name' => 'collection_id',
            'model' => '\App\Models\Collection',
            'attribute' => 'name',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'video',
            'type' => 'related_text',
            'tab' => $lightsTabName,
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'materials',
            'type' => 'related_text',
            'tab' => $lightsTabName,
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'bulbs',
            'type' => 'related_text',
            'tab' => $lightsTabName,
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'square',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'width',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'length',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'height',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'height_up',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'diameter',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'power',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'dimmer',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'protect',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'weight',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'name'  => 'volumn',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Install price',
            'name'  => 'install_price',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Attached bulbs',
            'name'  => 'attached_light',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Attached bulbs quantity',
            'name'  => 'bulbs_quantity',
            'type' => 'related_number',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Lamp color',
            'name'  => 'lamp_color',
            'type' => 'related_text',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Plafon color',
            'name'  => 'plafon_color',
            'type' => 'related_text',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Plafon material',
            'name'  => 'plafon_mat',
            'type' => 'related_text',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'entity' => 'light',
            'label' => 'Armature material',
            'name'  => 'armatura_mat',
            'type' => 'related_text',
            'tab' => $lightsTabName,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

// ----------- Bulb's props





        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $imagesArray = [];
        foreach ($request->images as $img) {
            if(isset($img) && !empty($img)) {
                $image = new Image();
                $image->filename = $img;
                $image->position = '0';
                $image->save();
                $imagesArray[] = $image->id;
            }
        }
//        var_dump($imagesArray); var_dump($request['categories']);
        unset($request['images']);
//        var_dump($request['images']);die;
//        $request->merge(array('images' => [$image->id]));
//        $request['image_id'] = $image->id;


        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        // return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
        unset($request['image1dark']);
        unset($request['title_image']);
		// your additional operations before save here
        $imagesArray = [];
        foreach ($request->images as $img) {
            if(isset($img) && !empty($img)) {
                $image = new Image();
                $image->filename = $img;
                $image->position = '0';
                $image->save();
                $imagesArray[] = $image->id;
            }
        }
//        var_dump($imagesArray); var_dump($request['categories']);
        unset($request['images']);
 
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
