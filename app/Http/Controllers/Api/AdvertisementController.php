<?php

namespace App\Http\Controllers\Api;


use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;

class AdvertisementController extends BaseController
{
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(10);
        return  $this->sendResponse($advertisements, 'lista de publicidades');
    }

    public function store(StoreAdvertisementRequest $request)
    {

        if ($request->hasFile('imagens')) {
            $image = $request->file('imagens')[0];
            $imageName = time() . '.' . $image->extension();

            $url = '/storage/' . $image->storeAs('advertisements', $imageName, 'public');;
            $request->merge(['image_url' => $url]);
        }


        $advertisement = Advertisement::create($request->all());

        return $this->sendResponse($advertisement, 'campanha criada com sucesso');
    }

    public function show(Advertisement $advertisement)
    {
        return $advertisement;
    }

    public function update(StoreAdvertisementRequest $request, Advertisement $advertisement)
    {
        $advertisement->update($request->validated());
        return response()->json($advertisement);
    }

    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();
        return response()->json(null, 204);
    }
}
