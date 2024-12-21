<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductFilteringService\CSVStrategy;
use App\Services\ProductFilteringService\DataFilter;
use App\Services\ProductFilteringService\XMLStrategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        return view('products.index', ['products' => Product::paginate(10)]);
    }

    public function upload()
    {
        return view('products.upload');
    }

    public function store(Request $request)
    {
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return back()->withErrors(['file' => 'Invalid file upload.']);
        }
        $fullPath = $this->uploadFile($request->file('file'));
        $extension = $request->file('file')->getClientOriginalExtension();

        $dataFilter = new DataFilter();

        switch ($extension) {
            case 'csv':
                $dataFilter->setStrategy(new CSVStrategy($fullPath));
                break;
            case 'xml':
                $dataFilter->setStrategy(new XMLStrategy($fullPath));
                break;
            default:
                return back()->withErrors(['file' => 'Unsupported file type.']);
        }

        $products = $dataFilter->execute();
        $this->addProducts($products);

        return redirect()->route('products.index')->with('success', 'Products imported successfully!');
    }

    private function uploadFile($file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();

        $destinationPath = storage_path('app/public/uploads');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true); // Ensure directory exists
            Log::info("Directory created at: " . $destinationPath);
        }

        try {
            $file->move($destinationPath, $fileName);
        } catch (\Exception $e) {
            Log::error("Failed to move file: " . $e->getMessage());
            return back()->withErrors(['file' => 'File upload failed.']);
        }

        return $destinationPath . '/' . $fileName;
    }

    private function addProducts($products): void
    {
        foreach ($products as $product) {
            Product::create(
                [
                    'name' => $product['name'],
                    'manufacturer' => $product['manufacturer'],
                    'additional' => $product['additional'],
                    'availability' => $product['availability'],
                    'price' => $product['price'],
                    'product_image' => $product['product_image'] ?? "",
                    'product_ref_id' => $product['product_ref_id'] ?? null,
                ]
            );
        }
    }
}
