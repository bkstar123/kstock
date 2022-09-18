<?php

namespace App\Http\Controllers;

use Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show all resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.settings.index');
    }

    /**
     * Update a resource
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'limits' => 'numeric|min:2|max:10'
        ]);
        $settings = $request->except('_token');
        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
        flashing('Settings are successfully updated')->success()->flash();
        return back();
    }
}
