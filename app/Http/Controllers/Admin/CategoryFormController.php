<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CategoryFormContract;
use App\Contracts\CategoryContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class CategoryFormController extends BaseController
{
    /**
         * @var CategoryFormContract
         * @var CategoryContract
         */
        protected $categoryFormRepository;
        protected $categoryRepository;

        /**
         * PageController constructor.
         * @param CategoryFormContract $categoryFormRepository
         * @param CategoryContract $categoryRepository
         */
        public function __construct(CategoryFormContract $categoryFormRepository, CategoryContract $categoryRepository)
        {
            $this->categoryFormRepository = $categoryFormRepository;
            $this->categoryRepository = $categoryRepository;
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index()
        {
            $forms = $this->categoryFormRepository->listForms();
            $this->setPageTitle('Forms', 'List of all forms');
            return view('admin.categoryforms.index',compact('forms'));
        }
        

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function create()
        {
            $categorytypes = $this->categoryRepository->listCategories();
            $this->setPageTitle('Custom Form', 'Create Form');
            return view('admin.categoryforms.create',compact('categorytypes'));
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function store(Request $request)
        {
        	/* $this->validate($request, [
                'name'      =>  'required|max:255',
            ]); */

            $validator = Validator::make($request->all(), [
                'form_name'  =>  'required|max:255',
            ])->setAttributeNames(
                ['form_name' => "name"]
            );
            // Validate the input and return correct response
            if ($validator->fails())
            {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400); // 400 being the HTTP code for an invalid request.
            }

        	$params = array();
        	$params['category_type'] = $request->category_type;
            $params['form_name'] = $request->form_name;
            $params['status'] = $request->status;
        	$params['field_array'] = serialize($request->field_array);
            // $params = $request->except('_token');
            if($params['status']==1)
            {
                if($params['category_type']>0)
                {
                   if(!empty($field_data = $this->categoryFormRepository->findFormByCategoryId($params['category_type'])))
                   {
                        $length=sizeof($field_data);
                        for($i=0; $i<$length; $i++) {
                            $duplicate = array();
                            $duplicate['id'] = $field_data[$i]->id;
                            $duplicate['check_status'] = 0; 
                            $this->categoryFormRepository->updateCategoryFormStatus($duplicate);  
                        }
                   } 
                }
                
            }
            $categoryform = $this->categoryFormRepository->createCategoryForm($params);
            
            if($categoryform)
            {
               return response()->json(array('message'=>'Successfully created')); 
            }
        }

        /**
         * @param $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function edit($id)
        {
            $targetForm = $this->categoryFormRepository->findFormById($id);
            $form_fields = unserialize($targetForm->field_values);
            $categorytypes = $this->categoryRepository->listCategories();
            
            $this->setPageTitle('Form', 'Edit Form');
            return view('admin.categoryforms.edit', compact('form_fields','targetForm','categorytypes'));
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function update(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'form_name'  =>  'required|max:255',
            ])->setAttributeNames(
                ['form_name' => "name"]
            );
            // Validate the input and return correct response
            if ($validator->fails())
            {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400); // 400 being the HTTP code for an invalid request.
            }

            $params = array();
            $params['id'] = $request->id;
            $params['category_type'] = $request->category_type;
            $params['form_name'] = $request->form_name;
            $params['status'] = $request->status;
            if($params['status']==1)
            {
                if($params['category_type']>0)
                {
                    if(!empty($field_data = $this->categoryFormRepository->findFormByCategoryId($params['category_type'])))
                    {
                         $length=sizeof($field_data);
                         for($i=0; $i<$length; $i++) {
                             $duplicate = array();
                             if($field_data[$i]->id != $params['id'])
                             {
                               $duplicate['id'] = $field_data[$i]->id;
                               $duplicate['check_status'] = 0; 
                               $this->categoryFormRepository->updateCategoryFormStatus($duplicate); 
                             }
                               
                         }
                    }
                }
                
            }
            $params['field_array'] = serialize($request->field_array);  

            $form = $this->categoryFormRepository->updateCategoryForm($params);

            if($form)
            {
                return response()->json(array('message'=>'Successfully updated'));
            }
        }

        /**
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function delete($id)
        {
            $form = $this->categoryFormRepository->deleteForm($id);

            if (!$form) {
                return $this->responseRedirectBack('Error occurred while deleting blog.', 'error', true, true);
            }
            return $this->responseRedirect('admin.customform.index', 'Custom Form deleted successfully' ,'success',false, false);
        }

        /**
         * @param $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function preview($id)
        {
            $targetForm = $this->categoryFormRepository->findFormById($id);
            $form_fields = unserialize($targetForm->field_values);
            $field_values = json_encode($form_fields);
            $this->setPageTitle('Form', 'Preview Form');
            return view('admin.categoryforms.preview', compact('field_values'));
        }

        public function getCategoryFormFields(Request $request)
        {
           $targetForm = $this->categoryFormRepository->findFormByCategoryId($request->id);
           $form_fields = unserialize($targetForm[0]->field_values);
           return $form_fields; 
        }
        /**
         * @param request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function updateStatus(Request $request){
            $params = array();
            $params['id'] = $request->form_id;
            $params['check_status'] = $request->check_status;
            $targetForm = $this->categoryFormRepository->findFormById($params['id']);
            if($params['check_status']==1)
            {
                if($targetForm->category_id>0)
                {
                    if(!empty($field_data = $this->categoryFormRepository->findFormByCategoryId($targetForm->category_id)))
                    {
                         $length=sizeof($field_data);
                         for($i=0; $i<$length; $i++) {
                             $duplicate = array();
                             if($field_data[$i]->id != $params['id'])
                             {
                               $duplicate['id'] = $field_data[$i]->id;
                               $duplicate['check_status'] = 0; 
                               $this->categoryFormRepository->updateCategoryFormStatus($duplicate); 
                             }
                               
                         }

                    }
                }
            }
            $category = $this->categoryFormRepository->updateCategoryFormStatus($params);

            if ($category) {
                return response()->json(array('message'=>'Form status successfully updated'));
            }
        }
 

        
}
