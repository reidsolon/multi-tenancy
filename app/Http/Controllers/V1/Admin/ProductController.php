<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function render()
    {
        return view('admin.products.index');
    }

    public function index(Request $request)
    {
        $collection = QueryBuilder::for(Product::class)
            ->allowedIncludes('photos')
            ->allowedSorts('name', 'description')
            ->defaultSort('-created_at')
            ->getOrPaginate();

        return ProductResource::collection($collection);
    }

    public function store(StoreRequest $request)
    {
        return DB::transaction(function () {
            $request = request();

            $data = $request->only('name', 'description');
            $data['price_in_cents'] = $request->price * 100;

            $product = Product::create($data);

            /** Save product photos here */
            if ($request->hasFile('photos'))
                $this->addMediaByModel($product, collect($request->file('photos')));

            return ProductResource::make($product->load('photos'));
        });
    }

    public function show(Product $product)
    {
        return ProductResource::make($product->load('photos'));
    }

    public function update(Product $product, UpdateRequest $request)
    {
        return DB::transaction(function () use ($product) {
            $request = request();

            $data = $request->only('name', 'description');
            $data['price_in_cents'] = $request->price * 100;

            $product->update($data);

            if ($request->has('delete_photos'))
                collect($request->delete_photos)
                    ->each(fn($del) => Media::find($del)?->delete());

            if ($request->has('photos'))
                $this->addMediaByModel($product, collect($request->file('photos')));

            return ProductResource::make($product->load('photos'));
        });
    }

    public function destroy(Product $product)
    {
        return DB::transaction(function () use ($product) {
            $product->delete();

            return response()->json([]);
        });
    }

    private function addMediaByModel(Product $product, Collection $photos)
    {
        DB::transaction(function () use ($product, $photos) {
            $uploadedFile = $photos->filter(function ($item) {
                return $item instanceof UploadedFile;
            });

            $uploadedFile->each(function ($file) use ($product) {
                $product->addMedia($file)
                    ->toMediaCollection($product->defaultCollectionName());
            });
        });
    }
}
