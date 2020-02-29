<?php

namespace App\Exports;

use App\Products;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class ProductsExport implements FromCollection,WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $collectProducts = [];

        $productsGroup = Products::all()->groupBy('model');

        $productsGroup->each( function( $products,$key) use (&$collectProducts) {
            $collectProducts[$key] = [];
            
            $products->each( function( $product,$keyp) use(&$collectProducts,&$key) {
                $collectProducts[$key][] = [
                    'name'  => $product->name,
                    'sku'   => $product->sku,
                    'color' => $product->attribute_color,
                ];
            });
        });

        $collect = [];
        $format = "|sku=%s,color=%s";

        foreach ($collectProducts as $key => $model)
        {
            $configurations_variatons = '';

  

            foreach ($model as $key_model => $product) {

                $collect[$key] = [
                    'model' => $key,
                    'name' => $product['name'],
                ];

                $configurations_variatons .= sprintf($format,$product['sku'],$product['color']);
            }

            $configurations_variatons = substr($configurations_variatons, 1); 

            $collect[$key]['configurations_variatons'] = $configurations_variatons;
      
        }

        return collect($collect);

        dd($collect);


  
        dd( Products::all()->groupBy('model') );
        
        return Products::all()->groupBy('model');
    }

    public function headings(): array
    {
        return [
            'sku(model)',
            'name',
            'configurations_variatons'
        ];
    }

}
