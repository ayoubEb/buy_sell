<?php

namespace App\Exports;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockXlsx implements FromCollection , WithHeadings , WithMapping , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
  protected $stocks;
    /**
    * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $stocks = Stock::select("produit_id","num","quantite","disponible","reste","min","max","date_stock","sortie","qte_alert","qte_achat","qte_vente","qte_augmenter","qte_achatRes","qte_venteRes","id")->get();
    return $this->stocks = $stocks;
  }

  public function headings(): array
  {
      return [
          Str::upper('#id'),
          Str::upper('référence'),
          Str::upper('Catégorie'),
          Str::upper('Designation'),
          Str::upper('Numéro'),
          Str::upper('Quantite'),
          Str::upper('disponible'),
          Str::upper('reste'),
          Str::upper('min'),
          Str::upper('max'),
          Str::upper('sortie'),
          Str::upper('alert'),
          Str::upper('achat'),
          Str::upper('vendu'),
          Str::upper('augmenter'),
          Str::upper('achat réserver'),
          Str::upper('vente réserver'),
          Str::upper('date création'),
      ];
  }

  public function map($stock): array
  {
    $produit = Produit::select("id","reference","designation","categorie_id")->where("id",$stock->produit_id)->first();
    $check_categorie = Categorie::where("id",$produit->categorie_id)->exists();
    if($check_categorie == true)
    {
      $categorie_nom = Categorie::where("id",$produit->categorie_id)->first()->nom;
    }
    else
    {
      $categorie_nom = "N/A";

    }

      return [
          "#".$stock->id,
          $produit->reference,
          $categorie_nom,
          $produit->designation,
          $stock->num,
          $stock->quantite,
          $stock->disponible,
          $stock->num,
          $stock->reste,
          $stock->min,
          $stock->max,
          $stock->sortie,
          $stock->qte_alert,
          $stock->qte_achat,
          $stock->qte_vente,
          $stock->qte_achatRes ,
          $stock->qte_venteRes ,
          $stock->date_stock,  // Format date
      ];
  }

  public function styles(Worksheet $sheet)
  {
    $sheet->getDefaultRowDimension()->setRowHeight(25);
    $sheet->getStyle('A1:R1')->applyFromArray([
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
    $sheet->getStyle('A:R')->applyFromArray([
      'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
      ],
    ]);
    $sheet->getStyle('E:R')->applyFromArray([
      'alignment' => [
        'horizontal' => Alignment::VERTICAL_CENTER,
      ],
    ]);
  }
}
