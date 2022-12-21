<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Common;
use Helper;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Spatie\Permission\Models\Role;
use Validator;

class ProductController extends Controller {

    public $user;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    public function index(Request $request) {
        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any role !');
        }

        $roles = Role::all();

        return view('product.index')->with(compact('roles'));
    }

    public function create(Request $request) { //passing param for custom function
        $qpArr = $request->all();

        return view('seal.create')->with(compact('qpArr'));
    }

    public function store(Request $request) {
        //begin back same page after update

        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '';
        //end back same page after update

        $validator = Validator::make($request->all(), [
                    'name' => 'required|unique:seal,name',
                    'order' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect('admin/product/create' . $pageNumber)
                            ->withInput()
                            ->withErrors($validator);
        }

        $target = new Product;
        $target->name = $request->name;
        $target->order = 0;
        $target->status = $request->status;

        if ($target->save()) {
            Session::flash('success', __('label.PRODUCT_HAS_BEEN_CREATED_SUCCESSFULLY'));
            return redirect('admin/product');
        } else {
            Session::flash('error', __('label.PRODUCT_COULD_NOT_BE_CREATED'));
            return redirect('admin/product/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {
        $target = Seal::find($id);
        $orderList = array('0' => __('label.SELECT_ORDER_OPT')) + getOrderList($this->controller, 2);
        if (empty($target)) {
            Session::flash('error', __('label.INVALID_DATA_ID'));
            return redirect('admin/seal');
        }

        //passing param for custom function
        $qpArr = $request->all();

        return view('seal.edit')->with(compact('target', 'qpArr', 'orderList'));
    }

    public function update(Request $request, $id) {
//     print_r($request->all());exit;
        $target = Seal::find($id);
        // return $request;
        $presentOrder = $target->order;
        // echo '<pre>';print_r($target);exit;
        //begin back same page after update
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter']; //!empty($qpArr['page']) ? '?page='.$qpArr['page'] : '';
        //end back same page after update

        $validator = Validator::make($request->all(), [
                    'name' => 'required|unique:seal,name,' . $id,
                    'order' => 'required|not_in:0',
                    'status' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return redirect('admin/seal/' . $id . '/edit' . $pageNumber)
                            ->withInput()
                            ->withErrors($validator);
        }

        $target->name = $request->name;
        $target->order = $request->order;
        $target->status = $request->status;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $fullName =Auth::user()->id . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $path = "public/uploads/seal/";
            if (!empty($target->logo)) {
                File::delete('public/uploads/seal/' . $target->logo);
            }
            $img->move($path, $fullName);
            $target->logo = $fullName;
        }

        if ($target->save()) {
            if ($request->order != $presentOrder) {
                updateOrder($this->controller, $request->order, $target->id, $presentOrder);
            }
            Session::flash('success', __('label.SEAL_HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return redirect('admin/seal' . $pageNumber);
        } else {
            Session::flash('error', __('label.SEAL_COULD_NOT_BE_UPDATED'));
            return redirect('admin/seal/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = Seal::find($id);

        //begin back same page after update
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        //end back same page after update

        if (empty($target)) {
            session()->flash('error', __('label.INVALID_DATA_ID'));
        }

        // //Dependency
        //        $dependencyArr = [
        //            'ProductCategory' => ['1' => 'parent_id'],
        //            'Product' => ['1' => 'product_category_id'],
        //        ];
        //        foreach ($dependencyArr as $model => $val) {
        //            foreach ($val as $index => $key) {
        //                $namespacedModel = '\\App\\' . $model;
        //                $dependentData = $namespacedModel::where($key, $id)->first();
        //                if (!empty($dependentData)) {
        //                    Session::flash('error', __('label.COULD_NOT_DELETE_DATA_HAS_RELATION_WITH_MODEL', ['model' => $model]));
        //                    return redirect('productType' . $pageNumber);
        //                }
        //            }
        //        }

        if ($target->delete()) {
            deleteOrder($this->controller, $target->order);
            Session::flash('error', __('label.SEAL_HAS_BEEN_DELETED_SUCCESSFULLY'));
        } else {
            Session::flash('error', __('label.SEAL_COULD_NOT_BE_DELETED'));
        }
        return redirect('admin/seal' . $pageNumber);
    }

    public function filter(Request $request) {
        $url = 'search=' . urlencode($request->search) . '&status=' . urlencode($request->status);
        return Redirect::to('admin/seal?' . $url);
    }

}
