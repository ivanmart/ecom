<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Config;
use Request;
use DB;

/**
 * SOAP Controller
 * It's designed to start with Cron scheduler and give text output for log file
 */

class SoapController extends Controller
{

    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * SoapController constructor
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
        $this->soapWrapper->add('1C', function ($service) {
            $service
                ->wsdl(Config::get('soap.wsdl'))
                ->options(Config::get('soap.options'))
                ->trace(true);
        });

        $p = new Product();
        $p->clearGlobalScopes();
    }

    /**
     * Update products from 1C
     * @param  Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $items = Product::where('updated_1c', '<', DB::raw('CURDATE()'))
                          ->take(100)
                          ->get();

        $ids = $items->pluck('name')->toArray();

        if (!count($ids)) {
            return;
        }

        $getCatalog = $this->soapWrapper->call('1C.GetCatalog', ['GetCatalog' =>
            ['ItemsList' => $ids]
        ]);

        $getIMParameters = $this->soapWrapper->call('1C.GetIMParameters', ['GetIMParameters' =>
            ['ItemsList' => $ids]
        ]);

        $from1c = [];

        if ($getCatalog->return->ErrorCode==0) {
            $getCatalog = $getCatalog->return->Data->enc_value->ItemCatalogLine;
            if (!is_array($getCatalog)) {
                $getCatalog=[$getCatalog];
            }
            foreach ($getCatalog as $item) {
                if ($item->IsFoundOK) {
                    $from1c[$item->ItemSKU][0] = $item;
                }
            }
        }

        if ($getIMParameters->return->ErrorCode==0) {
            $getIMParameters = $getIMParameters->return->Data->enc_value->IMParametersLine;
            if (!is_array($getIMParameters)) {
                $getIMParameters=[$getIMParameters];
            }
            foreach ($getIMParameters as $item) {
                if ($item->IsFoundOK) {
                    $from1c[$item->ItemSKU][1] = $item;
                }
            }
        }

        foreach ($items as $item) {
            if (isset($from1c[$item->name])) {
                $updated = false;

                $gc = isset($from1c[$item->name]) && isset($from1c[$item->name][0]) ? $from1c[$item->name][0] : false;
                if ($gc && $gc->IsFoundOK) {
                    $lamp_base = "";
                    if (isset($gc->LightBulbs->BulbsLine)) {
                        $bl = $gc->LightBulbs->BulbsLine;
                        $lights = gettype($bl) != 'array' ? [$bl] : $bl;
                        foreach ($lights as $light) {
                            if (isset($light->LightBulbBase) && strpos($light->LightBulbBase, "LED") === false) {
                                $lamp_base = $light -> LightBulbBase;
                            }
                        }
                    }

                    $item->light->diameter = $gc->Diameter;
                    $item->light->height = $gc->Height;
                    $item->light->height_up = $gc->SuspensionHeight;
                    $item->light->length = $gc->Lenght;
                    $item->light->width = $gc->Width;
                    $item->light->weight = $gc->Weight;
                    $item->light->protect = $gc->IPDefence;
                    $item->light->square = $gc->LighteningSurface;
                    $item->light->power = $gc->AggregatePower;
                    $item->light->attached_light = $gc->LightbulbsSupplied;
                    $item->light->dimmer = $gc->DimmerConnectAbility;
                    $item->light->base = $lamp_base;
                    $item->light->bulbs = serialize($gc->LightBulbs);
                    $item->light->plafon_color = trim($gc->PlafondColor);
                    $item->light->lamp_color = trim($gc->FittingsColor);
                    $item->light->plafon_mat = trim($gc->PlafondMaterial);
                    $item->light->armatura_mat = trim($gc->FittingsMaterial);
                    $item->light->colortemp = $gc->ColorfulTemperature;

                    $item->first_delivered = $gc->FirstDeliveryDate;
                    $item->txtArtisticDescription = $gc->txtArtisticDescription;
                    $item->txtAdvantages = $gc->txtAdvantages;
                    $item->txtRoomType = $gc->txtRoomType;
                    $item->txtInteriorDesignSolutions = $gc->txtInteriorDesignSolutions;
                    $item->txtProductionTechnology = $gc->txtProductionTechnology;
                    $updated = true;
                }

                $ip = isset($from1c[$item->name]) && isset($from1c[$item->name][1]) ? $from1c[$item->name][1] : false;
                if ($ip && $ip->IsFoundOK) {
                    $item->price = $ip->Price;
                    $item->old_price = $ip->OldPrice;
                    $item->light->install_price = $ip->CostOfAssembling;
                    $item->stock_rus = $ip->StockRus;
                    $item->stock_eu = $ip->StockEU;
                    $item->discontinued = $ip->Discontinued;
                    $updated = true;
                }

                if ($updated) {
                    echo $item->name."<br>";

                    $item->updated_1c = date("Y-m-d");
                    $item->light->save();
                    $item->save();
                }
            }
        }
    }
}
