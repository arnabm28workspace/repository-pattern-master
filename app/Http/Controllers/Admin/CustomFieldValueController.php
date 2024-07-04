<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\CustomFieldValue;
use App\Contracts\CustomFieldContract;

class CustomFieldValueController extends BaseController
{
    /**
     * @var CustomFieldContract
     */
    protected $customfieldRepository;

    /**
     * CustomFieldValueController constructor.
     * @param CustomFieldContract $customfieldRepository
     */
    public function __construct(CustomFieldContract $customfieldRepository)
    {
        $this->customfieldRepository = $customfieldRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $customfieldId = $id;
        $customfield = $this->customfieldRepository->findCustomFieldById($customfieldId);
        $values = $customfield->values;
        $this->setPageTitle($customfield->name.' values', '');
        return view('admin.customfields.options.index', compact('values', 'customfieldId'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $customfield = $this->customfieldRepository->findCustomFieldById($id);

        $this->setPageTitle('Add option : '.$customfield->name, 'Create Custom Field');
        return view('admin.customfields.options.create', compact('customfield'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $value = new CustomFieldValue();
        $value->customfield_id = $request->customfield_id;
        $value->value = $request->value;
        $value->save();

        if (!$value) {
            return $this->responseRedirectBack('Error occurred while adding custom field value.', 'error', true, true);
        }
        return $this->responseRedirectBack('Custom field value added successfully.', 'info', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, $valueID)
    {
        $customfield = $this->customfieldRepository->findCustomFieldById($id);
        $customfieldValue = CustomFieldValue::where('id', $valueID)->first();
        $this->setPageTitle('Edit option : '.$customfield->name, '');
        return view('admin.customfields.options.edit', compact('customfield', 'customfieldValue'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $customfieldValue = CustomFieldValue::findOrFail($request->input('id'));
        $customfieldValue->value = $request->input('value');
        $customfieldValue->save();

        if (!$customfieldValue) {
            return $this->responseRedirectBack('Error occurred while updating custom field value.', 'error', true, true);
        }
        return $this->responseRedirectBack('Custom field value updated successfully.', 'info', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, $valueID)
    {
        $customfieldValue = CustomFieldValue::findOrFail($valueID);
        $customfieldValue->delete();

        if (!$customfieldValue) {
            return $this->responseRedirectBack('Error occurred while deleting custom field value.', 'error', true, true);
        }
        return $this->responseRedirectBack('Custom field value deleted successfully.', 'info', false, false);
    }
}
