<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Categorie;
use App\Models\Depot;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class StockDepotXlsx implements FromCollection , WithHeadings, WithMapping , WithStyles , ShouldAutoSize , WithColumnFormatting , WithStrictNullComparison
{
  protected $stockDepots;
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $stockDepots = StockDepot::select("id","stock_id","depot_id","quantite","inactive","entre","sortie","disponible","check_default","statut","id")->get();
    return $this->stockDepots = $stockDepots;
  }
  public function headings(): array
  {
      return [
          Str::upper('#id'),
          Str::upper('référence'),
          Str::upper('Catégorie'),
          Str::upper('Designation'),
          Str::upper('Numéro stock'),
          Str::upper('depôt'),
          Str::upper('Quantite'),
          Str::upper('disponible'),
          Str::upper('sortie'),
          Str::upper('entre'),
          Str::upper('inactive'),
          Str::upper('défault'),
          Str::upper('statut'),
      ];
  }


  public function map($stockDepot): array
  {
    $stock           = Stock::select("id","produit_id","num")->where("id",$stockDepot->stock_id)->first();
    $depot           = Depot::select("id","num_depot")->where("id",$stockDepot->depot_id)->first();
    $produit         = Produit::select("id","categorie_id","reference","designation")->first();
    $check_categorie = Categorie::where("id",$produit->categorie_id)->exists();
    if($check_categorie == true)
    {
      $categorie_nom = Categorie::where("id",$produit->categorie_id)->first()->nom;
    }
    else
    {
      $categorie_nom = null;

    }

      return [
          "#".$stockDepot->id,
          $produit->reference,
          $categorie_nom,
          $produit->designation,
          $stock->num,
          $depot->num_depot,
          $stockDepot->quantite ,
          $stockDepot->disponible ,
          $stockDepot->sortie ,
          $stockDepot->entre,
          $stockDepot->inactive, // Corrected line
          $stockDepot->check_default == 1 ? 'oui' : 'non',
          $stockDepot->statut == 1 ? 'active' : 'inactive',
      ];
  }


  public function columnFormats(): array
  {
    // Define the columns that need number formatting
    $columns = ['F', 'G', 'H', 'I', 'J'];

    // Use array_map to create the format array
    return array_fill_keys($columns, NumberFormat::FORMAT_NUMBER);
  }

  public function styles(Worksheet $sheet)
  {
    // Alternatively, set default row height
    $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
    $sheet->getStyle('A1:M1')->applyFromArray([
      'font' => [
          'bold' => true,
          'size' => 10,
      ],
      'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
      ],
      'fill' => [
          'fillType' => Fill::FILL_SOLID,
          'startColor' => [
              'argb' => 'FFDDDDDD', // Light gray
          ],
      ],
    ]);
    $sheet->getStyle('A:M')->applyFromArray([
      'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,

      ],
    ]);
    $sheet->getStyle('F:L')->applyFromArray([
      'alignment' => [
        'horizontal' => Alignment::VERTICAL_CENTER,

      ],
    ]);

      foreach ($this->stockDepots as $rowIndex => $stockDepot) {
        $excelRow = $rowIndex + 2; // Data starts at row 2 (row 1 is headers)

        if ($stockDepot->statut == 1) {
          $sheet->getStyle("M{$excelRow}")->applyFromArray([

            'font' => [
                'color' => [
                  'argb'=>Color::COLOR_DARKGREEN  // Set font color to green
                  ]
            ],
          ]);
        } else {
          $sheet->getStyle("M{$excelRow}")->applyFromArray([

            'font' => [
                'color' => [
                  'argb'=>Color::COLOR_DARKRED  // Set font color to green
                  ]
            ],
          ]);
        }
        if ($stockDepot->check_default == 1) {
          $sheet->getStyle("K{$excelRow}")->applyFromArray([

            'font' => [
                'color' => [
                  'argb'=>Color::COLOR_DARKGREEN  // Set font color to green
                  ]
            ],
          ]);
        } else {
          $sheet->getStyle("K{$excelRow}")->applyFromArray([

            'font' => [
                'color' => [
                  'argb'=>Color::COLOR_DARKRED  // Set font color to green
                  ]
            ],
          ]);
        }


     }
  }
}
