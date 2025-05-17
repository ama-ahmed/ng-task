<?php

namespace core\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use core\Services\ServiceInterface;

abstract class ControllerAbstract extends Controller
{

    protected array $append = [];
    protected string $storeRequest;
    protected string $updateRequest;
    protected string $viewsPath;
    protected string $routeName = "";
    protected array $mediaCollections;
    protected array $filter = [];
    protected array $with = [];


    public function __construct(protected ServiceInterface $service)
    {
        $this->setFilter();
    }

    private function setFilter(): void
    {
        $this->filter = array_merge(request()->input('search') ?? [],
            $this->filter
        );
    }


    public function index(): View
    {
        $items = $this->service->paginate($this->filter,$this->with);
        return view("{$this->viewsPath}.index", ['items' => $items]);
    }


    public function create(): View
    {
        return view("{$this->viewsPath}.form", [
            'action' => $this->routeName.'.store',
            'method' => 'POST',
            'data' => $this->append
        ]);
    }

    public function store(Request $request)
    {
        $request = app($this->storeRequest);
        try {
            $model = $this->service->create($request->validated());

            if (isset($this->mediaCollections)) {
                $model->registerMediaCollection($this->mediaCollections);
            }

            return redirect()->route($this->routeName . '.index');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    public function show($id)
    {
        $model = $this->service->findOrFail($id,  with: $this->with);
        return view( "{$this->viewsPath}.view", ['model' => $model]);
    }


    public function edit($id)
    {
        $model = $this->service->findOrFail($id, with: $this->with);

        return view("{$this->viewsPath}.form", [
            'model' => $model,
            'action' => $this->routeName.'.update',
            'method' => 'PUT',
            'data' => $this->append
        ]);
    }

    public function update(Request $request, $id)
    {
        $request = app($this->updateRequest);

        try {
            $model = $this->service->findOrFail($id, $this->filter);

            $this->service->update($request->validated(), $model);

            if (isset($this->mediaCollections)) {
                $model->registerMediaCollections($this->mediaCollections);
            }
            return redirect()->route($this->routeName . '.index');

        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }


    public function destroy($id)
    {
        $model = $this->service->findOrFail($id, $this->filter);

        $this->service->delete($model);

        return redirect()->route($this->routeName . '.index');
    }
}
