<?php

namespace App\Services\ProductFilteringService;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CSVStrategy implements DataSourceStrategy
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function fetchAndFilterData(): array
    {
        $products = collect();
        $product_attributes = ((new Product)->getFillable());

        if (($handle = fopen($this->filePath, 'r')) !== false) {
            $header = fgets($handle);
            $columnMap = $this->cleanHeader($header);

            while (($data = fgetcsv($handle)) !== FALSE) {
                $combinedContent = implode(' ', array_filter($data, 'strlen'));
                Log::info("combinedContent: " . json_encode($combinedContent));
                if ($combinedContent != null) {
                    $productData = [];
                    $passed_data = $this->cleanData($combinedContent);
                    Log::info("passed_data" . json_encode($passed_data));
                    foreach ($columnMap as $index => $attribute) {
                        if (in_array($attribute, $product_attributes)) {
                            if (strpos($attribute, "product_image") !== false) {
                                $productData['product_image'] = $passed_data[$index];
                            } else {
                                switch ($attribute) {
                                    case 'price':
                                        $productData[$attribute] = $this->formatPrice($passed_data[$index]);
                                        break;
                                    case 'id':
                                        $productData['product_ref_id'] = $passed_data[$index];
                                        break;

                                    default:
                                        $productData[$attribute] = $passed_data[$index];
                                }
                            }
                        }
                    }

                    $product = new Product($productData);
                    Log::info("Product" . $product);
                    $products->push($product);
                }
            }
            fclose($handle);
        }
        return $products->toArray();
    }

    private function cleanHeader($header): array
    {
        $words = explode(';', $header);
        $cleanedWords = array_map(function ($word) {
            return str_replace([' ', ',', "'", '"', '\r', '\n'], '', $word);
        }, $words);

        return $cleanedWords;
    }

    private function cleanData($data)
    {
        $words = explode(';', $data);
        $cleanedWords = array_map(function ($word) {
            return str_replace(["'", '"'], '', $word);
        }, $words);

        return $cleanedWords;
    }

    private function formatPrice($price)
    {
        return (float) str_replace(',', '.', $price);
    }
}
