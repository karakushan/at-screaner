<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.exchanges.index', [
            'exchanges' => Exchange::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.exchanges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExchangeRequest $request)
    {
        Exchange::create($request->all());

        return redirect()->route('exchanges.index')
            ->with('success', __('Exchange created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.exchanges.edit', [
            'exchange' => Exchange::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExchangeRequest $request, $id)
    {
        $exchange = Exchange::findOrFail($id);

        if ($request->hasFile('logo')) {
            $exchange->deleteLogo();
            $request->merge([
                'logo_url' => $request->file('logo')->store('exchanges', 'public')
            ]);
        }

        $exchange->update($request->all());

        return redirect()->route('exchanges.index')
            ->with('success', __('Exchange updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exchange = Exchange::findOrFail($id);
        $exchange->delete();

        return redirect()->route('exchanges.index')
            ->with('success', __('Exchange deleted successfully.'));
    }
}
