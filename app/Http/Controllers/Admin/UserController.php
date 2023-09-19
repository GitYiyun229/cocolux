<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeProfile;
use App\Http\Requests\User\UpdatePassword;
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\UpdateUser;
use App\Repositories\Contracts\UserInterface;
use App\Repositories\Contracts\RoleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    /**
     * UserController constructor.
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     */
    public function __construct(UserInterface $userRepository,RoleInterface $roleRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UsersDataTable $dataTable
     * @return mixed
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->getAll();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUser $req)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create([
                'name' => $req->input('name'),
                'email' => $req->input('email'),
                'phone' => $req->input('phone'),
                'password' => Hash::make($req->input('password')),
                'status' => $req->input('status'),
                'type' => $req->input('type'),
                'gender' => $req->input('gender'),
                'birthday' => $req->input('birthday'),
                'address' => $req->input('address'),
            ]);
            if (!empty($req->input('role_id'))) {
                $user->assignRole($req->input('role_id'));
            }

            DB::commit();
            Session::flash('success', trans('message.create_user_success'));

            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->getOneById($id);
        $roles = $this->roleRepository->getAll();
        return view('admin.users.update',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateUser $req
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateUser $req)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getOneById($id);
            $user->update([
                'name' => $req->input('name'),
                'email' => $req->input('email'),
                'phone' => $req->input('phone'),
                'status' => $req->input('status'),
                'type' => $req->input('type'),
                'gender' => $req->input('gender'),
                'birthday' => $req->input('birthday'),
                'address' => $req->input('address'),
            ]);

            if (empty($req->input('role_id'))) {
                $user->syncRoles([]);
            } else {
                $user->syncRoles($req->input('role_id'));
            }

            DB::commit();
            Session::flash('success', trans('message.update_user_success'));
            return redirect()->route('admin.users.edit', $id);
        } catch (\Exception $exception) {
            DB::rollback();

            Session::flash('danger', trans('message.update_user_error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_user_success')
        ];
    }

    public function getProfile()
    {
        $user = auth()->user();
        return view('admin.users.change_profile', compact('user'));
    }

    public function changeProfile(ChangeProfile $request)
    {
        auth()->user()->update($request->validated());
        Session::flash('success', trans('message.update_user_success'));

        return redirect()->back();
    }

    public function changePassword()
    {
        return view('admin.users.change_password');
    }

    public function updatePassword(UpdatePassword $request)
    {
        if (Hash::check($request->password_current, auth()->user()->password) == false) {
            Session::flash('danger', trans('message.password_incorrect'));
            return redirect()->back();
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);

        Session::flash('success', trans('message.change_password_success'));
        return redirect()->back();
    }
}
