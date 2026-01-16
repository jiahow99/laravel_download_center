<?php

namespace Mices\DownloadCenter\Http\Controllers\Admin;

use App\Http\Requests\DownloadCenterRequest;
use Mices\DownloadCenter\Models\DownloadCenter;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DownloadCenterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DownloadCenterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(DownloadCenter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/download-center');
        CRUD::setEntityNameStrings('download center', 'download centers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->setOperationSetting('lineButtonsAsDropdown', false);

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => 'Name',
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'  => 'initiated_by',
            'label' => 'Initiated By',
            'type'  => 'closure',
            'function' => function ($entry) {
                return optional($entry->initiatedBy)->name ?? '-';
            },
        ]);

        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Initiated At',
            'type'  => 'datetime',
        ]);

        $this->crud->addColumn([
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'custom_html',
            'value' => function ($entry) {
                $label = DownloadCenter::getStatusLabel($entry->status);
                switch ($entry->status) {
                    case DownloadCenter::STATUS_PENDING:
                        return "<span class='fw-bold text-warning'>{$label}</span>";
                        break;
                    case DownloadCenter::STATUS_COMPLETED:
                        return "<span class='fw-bold text-success'>{$label}</span>";
                        break;
                    case DownloadCenter::STATUS_FAILED:
                        return "<span class='fw-bold text-danger'>{$label}</span>";
                        break;
                    case DownloadCenter::STATUS_EXPIRED:
                        return "<span class='fw-bold text-muted'>{$label}</span>";
                        break;
                    
                    default:
                        return "<span class='fw-bold text-danger'>{$label}</span>";
                        break;
                }
            },
        ]);

        $this->crud->addButton('line', 'download', 'view', 'download', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DownloadCenterRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
