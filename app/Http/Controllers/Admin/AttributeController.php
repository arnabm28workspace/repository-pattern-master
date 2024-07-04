<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Contracts\AttributeContract;

class AttributeController extends BaseController
{
    /**
     * @var AttributeContract
     */
    protected $attributeRepository;

    /**
     * AttributeController constructor.
     * 
     * @param AttributeContract $attributeRepository
     */
    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = $this->attributeRepository->listAttributes();
        $this->setPageTitle('Attribute', 'List of all attributes');
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Attribute', 'Create Attribute');
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'colname'      =>  'required|max:255',
            'label' =>  'required',
            'field_type' =>  'required',
        ]);

        $params = $request->except('_token');

        $attr = $this->attributeRepository->createAttribute($params);

        if (!$attr) {
            return $this->responseRedirectBack('Error occurred while creating country.', 'error', true, true);
        }
        return $this->responseRedirect('admin.attribute.index', 'Attribute has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);
        $types = ['select' => 'Select Box', 'radio' => 'Radio Button', 'text' => 'Text Field', 'text_area' => 'Text Area'];
        $this->setPageTitle('Attribute', 'Edit Attribute : '.$attribute->name);
        return view('admin.attributes.edit', compact('attribute', 'types'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'colname'      =>  'required|max:255',
            'label' =>  'required',
            'field_type' =>  'required',
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->updateAttribute($params);

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while updating attribute.', 'error', true, true);
        }
        return $this->responseRedirectBack('Attribute updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $attribute = $this->attributeRepository->deleteAttribute($id);

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while deleting attribute.', 'error', true, true);
        }
        return $this->responseRedirect('admin.attribute.index', 'Attribute deleted successfully' ,'success',false, false);
    }
}