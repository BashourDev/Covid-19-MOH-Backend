<?php

namespace App\Http\Controllers;

use App\Models\ProvincialAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class ProvincialAdminController extends Controller
{
    //

    public function index(Request $request)
    {
        return response(ProvincialAdmin::query()->where('name', 'like', '%'.$request->get('name').'%')->with(['province'])->withCount(['hospitals'])->get());
    }

    public function store(Request $request)
    {
        return response(ProvincialAdmin::query()->create([
                'role' => User::ROLE_PROVINCIAL_ADMIN,
                'province_id' => $request->get('province_id'),
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'password' => bcrypt($request->get('password')),
//                'plainPassword' => $request->get('password')
            ]));
    }

    public function show(ProvincialAdmin $provincialAdmin)
    {
        return response($provincialAdmin->loadMissing('hospitals'));
    }

    public function update(Request $request, ProvincialAdmin $provincialAdmin)
    {
        $provincialAdmin->update([
            'name' => $request->get('name'),
            'username' => $request->get('username'),

        ]);

        if ($request->get('update_password')) {
            $provincialAdmin->password = bcrypt($request->get('password'));
            $provincialAdmin->save();
        }

        return response('ok');
    }

    public function destroy(ProvincialAdmin $provincialAdmin)
    {
        return response($provincialAdmin->delete());
    }

    public function hospitals()
    {
        return response(auth()->user()->cast()->hospitals);
    }
}
