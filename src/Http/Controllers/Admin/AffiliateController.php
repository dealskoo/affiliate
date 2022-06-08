<?php

namespace Dealskoo\Affiliate\Http\Controllers\Admin;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('affiliates.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('affiliate::admin.affiliate.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'email', 'status', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Affiliate::query();
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('email', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $affiliates = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('affiliates.show');
        $can_edit = $request->user()->canDo('affiliates.edit');
        $can_login = $request->user()->canDo('affiliates.login');
        foreach ($affiliates as $affiliate) {
            $row = [];
            $row[] = $affiliate->id;
            $row[] = '<img src="' . $affiliate->avatar_url . '" alt="' . $affiliate->name . '" title="' . $affiliate->name . '" class="me-2 rounded-circle"><p class="m-0 d-inline-block align-middle font-16">' . $affiliate->name . '</p>';
            $row[] = $affiliate->email;
            $row[] = $affiliate->status ? '<span class="badge bg-success">' . __('affiliate::affiliate.active') . '</span>' : '<span class="badge bg-danger">' . __('affiliate::affiliate.inactive') . '</span>';
            $row[] = $affiliate->created_at->format('Y-m-d H:i:s');
            $row[] = $affiliate->updated_at->format('Y-m-d H:i:s');

            $login_link = '';
            if ($can_login) {
                $login_link = '<a href="' . route('admin.affiliates.login', $affiliate) . '" class="action-icon" target="_blank"><i class="mdi mdi-view-dashboard"></i></a>';
            }

            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.affiliates.show', $affiliate) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.affiliates.edit', $affiliate) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $row[] = $login_link . $view_link . $edit_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('affiliates.show'), 403);
        $affiliate = Affiliate::query()->findOrFail($id);
        return view('affiliate::admin.affiliate.show', ['affiliate' => $affiliate]);
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('affiliates.edit'), 403);
        $affiliate = Affiliate::query()->findOrFail($id);
        return view('affiliate::admin.affiliate.edit', ['affiliate' => $affiliate]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('affiliates.edit'), 403);
        $affiliate = Affiliate::query()->findOrFail($id);
        $affiliate->status = $request->boolean('status', false);
        $affiliate->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function login(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('affiliates.login'), 403);
        $affiliate = Affiliate::query()->findOrFail($id);
        Auth::guard('affiliate')->login($affiliate);
        return redirect(route('affiliate.dashboard'));
    }
}
