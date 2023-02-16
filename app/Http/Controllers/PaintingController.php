<?php

namespace App\Http\Controllers;

use App\Painting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PaintingResource;
use App\Http\Resources\PaintingCollection;
use App\Http\Requests\PaintingStoreRequest;
use App\Http\Requests\PaintingUpdateRequest;

class PaintingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PaintingCollection
     */
    public function index() :PaintingCollection
    {
        $paintings = Painting::allowedSorts(Painting::$allowedSorts);

        //filters
        foreach (request('filter', []) as $filter => $value) {
            abort_unless(in_array($filter, Painting::$allowedFilters), 400);
            $paintings->{$filter}($value);
        }

        return PaintingCollection::make(
            $paintings->paginate(
                $perPage = request('page.size', 15),
                $columns = ['*'],
                $pageName = 'page[number]',
                $page = request('page.number', 1)
            )->appends(request()->only('sort', 'page.size'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PaintingStoreRequest  $request
     * @return PaintingResource
     */
    public function store(PaintingStoreRequest $request) :PaintingResource
    {
        $painting = Painting::create($request->input('data.attributes'));

        return PaintingResource::make($painting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Painting  $painting
     * @return PaintingResource
     */
    public function show(Painting $painting) :PaintingResource
    {
        return PaintingResource::make($painting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaintingUpdateRequest  $request
     * @param  \App\Painting  $painting
     * @return PaintingResource
     */
    public function update(PaintingUpdateRequest $request, Painting $painting) :PaintingResource
    {
        $painting->update($request->input('data.attributes'));

        return PaintingResource::make($painting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Painting  $painting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Painting $painting) :Response
    {
        $painting->delete();

        return response()->noContent();
    }
}
