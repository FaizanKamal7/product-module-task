# Product Display Module for Web Shop - ALZURA 

## Overview
This project implements a module to fetch and normalize product data from various sources (e.g., CSV, XML) and display it on a unified result page. The design employs the **Strategy Pattern** to handle multiple data sources efficiently.

---

## Features
- Fetch data from CSV, XML sources (you can upload the csv files for testing now) and flexibile for other sources.
- Utilized Strategy design pattern for flexible implementation
- Normalize data to include:
  - **Title**
  - **Manufacturer**
  - **Description**
  - **Price**
  - **Availability**
  - **Product Image**
- Modular and extensible design for future data sources.
- Error handling for inconsistent or missing data.
- User-friendly interface for uploading product files.

---

## System Architecture

### Class Diagram
![class_diagram](https://github.com/user-attachments/assets/bff6abe5-8d53-4c60-b576-fd4def90c247)


### Components
1. **DataFetcher**: Fetches raw product data from various sources.
2. **DataSourceStrategy**: Interface for implementing different source strategies (e.g., CSV, XML).
3. **DataNormalizer**: Standardizes raw product data into normalized attributes.
4. **ProductDisplay**: Aggregates normalized data and renders it on the result page.

---

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/FaizanKamal7/product-module.git
   ```
2. Navigate to the project directory:
   ```bash
   cd product-module
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Set up the environment file:
   ```bash
   cp .env.example .env
   ```
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```

---

## Usage
1. Navigate to the file upload page.
2. Upload a CSV or XML file containing product data.
3. The system will:
   - Identify the file type.
   - Normalize the data.
   - Store the data in the database.
4. View the unified product listing page.

---

## Example Code Snippets

### Controller
```php
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
```
![image](https://github.com/user-attachments/assets/632fbfe5-381a-4fe8-a00c-98bfa35b54a6)
![image](https://github.com/user-attachments/assets/95f37b4c-2d66-4884-8d2f-38fc129ba000)

---

## Testing
- Run the test suite:
  ```bash
  php artisan test
  ```
- Verify:
  - Data normalization logic.
  - File upload and error handling.
  - Display functionality with different data formats.

---

