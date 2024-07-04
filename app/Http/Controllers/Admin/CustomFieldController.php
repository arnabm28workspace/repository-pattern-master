<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Contracts\CustomFieldContract;

class CustomFieldController extends BaseController
{
    /**
     * @var CustomFieldContract
     */
    protected $customfieldRepository;

    /**
     * CustomFieldController constructor.
     * @param CustomFieldContract $customfieldRepository
     */
    public function __construct(CustomFieldContract $customfieldRepository)
    {
        $this->customfieldRepository = $customfieldRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customfields = $this->customfieldRepository->listCustomFields();

        $this->setPageTitle('Custom Field', 'List of all custom field');
        return view('admin.customfields.index', compact('customfields'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $types = ['text', 'textarea', 'checkbox', 'radio', 'select'];
        $this->setPageTitle('Custom Field', 'Create Custom Field');
        return view('admin.customfields.create', compact('types'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required',
            'type'      =>  'required',
        ]);

        $params = $request->except('_token');

        $customfield = $this->customfieldRepository->createCustomField($params);

        if (!$customfield) {
            return $this->responseRedirectBack('Error occurred while creating custom field.', 'error', true, true);
        }
        return $this->responseRedirect('admin.customfield.index', 'Custom field added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $customfield = $this->customfieldRepository->findCustomFieldById($id);
        $types = ['text', 'textarea', 'checkbox', 'radio', 'select'];
        $this->setPageTitle('Custom Field', 'Edit Custom Field : '.$customfield->name);
        return view('admin.customfields.edit', compact('customfield', 'types'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required',
            'type'  =>  'required'
        ]);

        $params = $request->except('_token');

        $customfield = $this->customfieldRepository->updateCustomField($params);

        if (!$customfield) {
            return $this->responseRedirectBack('Error occurred while updating custom field.', 'error', true, true);
        }
        return $this->responseRedirectBack('Custom Field updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $customfield = $this->customfieldRepository->deleteCustomField($id);

        if (!$customfield) {
            return $this->responseRedirectBack('Error occurred while deleting custom field.', 'error', true, true);
        }
        return $this->responseRedirect('admin.customfield.index', 'Custom field deleted successfully' ,'success',false, false);
    }
}
