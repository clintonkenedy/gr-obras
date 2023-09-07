<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Avance;
use App\Models\AvanceMes;
use App\Models\Obra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvanceMesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $avancemes = AvanceMes::with('files')->where('obra_id', $request->obra_id)->get();
        return response($avancemes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('bin')) {
                // CREAR AVANCEMES
                $sum_programado = 0;
                $sum_fisico = 0;
                $sum_financiero = 0;
                $obra = Obra::find($request->obra_id);
                // obtener gasto directo si es el primer avance de la obra.
                $presupuesto = $obra->presupuesto->reverse()->first();
                $costo_directo = $presupuesto->gasto->reverse()->first()->costo_directo;
                $ppto = $presupuesto->ppto;
                $saldo_anterior = $obra->avancemeses->slice(1, 1)->first()->saldo ?? $costo_directo; //cambiar costo directo
                $avanceMes = AvanceMes::firstOrCreate(
                    [
                        'codigo' => $request->mes . $request->anio,
                    ],
                    [
                        'saldo' => $saldo_anterior,
                        'obra_id' => $obra->id
                    ]
                );
                // LEER ARCHIVO
                $archivo = $request->file('bin');
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $reader->setReadDataOnly(true);
                // $reader->setLoadSheetsOnly("Sheet1");
                $document = $reader->load($archivo);
                $data = $document->getSheet(0)->toArray(null, true, true, true);
                unset($reader);
                $codigo_semana = 100;
                $codigo = "132zxcva%";
                foreach ($data as $id => $row) {
                    if ($id == 1) continue;
                    $codigo_excel = strtolower(trim($row['A'])); // Quitar espacios y minúscula
                    if ($codigo != $codigo_excel) {
                        $codigo_semana = 100;
                        $codigo = $codigo_excel;
                    } else $codigo_semana++;
                    Avance::updateOrCreate(
                        [
                            'codigo_semana' => $codigo_excel . '-' . $codigo_semana,
                            'avance_mes_id' => $avanceMes->id,
                        ],
                        [
                            'codigo' => $codigo_excel,
                            'monto_prog' => $row['B'],

                            'monto_fisic' => $row['C'],

                            'monto_finan' => $row['D'],
                        ]
                    );
                    $sum_programado += $row['B'];
                    $sum_fisico += $row['C'];
                    $sum_financiero += $row['D'];
                }
                // 
                $avanceMes->update([
                    'sum_programado' => $sum_programado,
                    'sum_fisico' => $sum_fisico,
                    'sum_financiero' => $sum_financiero
                ]);

                $a = Avance::where('avance_mes_id', $avanceMes->id)->get();
                $v1 = 0;
                $v2 = 0;
                $v3 = 0;
                foreach ($a as $id => $r) {
                    $m1 = null;
                    $m2 = null;
                    $m3 = null;
                    if (!is_null($r->monto_prog)) {
                        $m1 = ($r->monto_prog / $costo_directo) * 100;
                        $v1 += round($m1, 2);
                    }
                    if (!is_null($r->monto_fisic)) {
                        $m2 = ($r->monto_fisic / $costo_directo) * 100;
                        $v2 += round($m2, 2);
                    }
                    if (!is_null($r->monto_finan)) {
                        $m3 = ($r->monto_finan / $ppto) * 100;
                        $v3 += round($m3, 2);
                    }

                    $r->update(
                        [
                            'porcentaje_prog' => $m1,
                            'acum_prog' => !is_null($r->monto_prog) ?  $v1 : null,

                            'porcentaje_fisc' => $m2,
                            'acum_fisc' => !is_null($r->monto_fisic) ? $v2 : null,

                            'porcentaje_finan' => $m3,
                            'acum_finan' => !is_null($r->monto_finan) ? $v3 : null,
                        ]
                    );
                }
            }
            Archivo::AgregarArchivos($request, avance_mes_id: $avanceMes->id);
            return response($obra, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No hay archivo',
                'error' => $e->getMessage(),
            ], 400);
        }
        // return response(AvanceMes::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idObra)
    {
        $avanceMes = AvanceMes::with('avances')->where('obra_id', $idObra)->get()->reverse()->first();
        return response($avanceMes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = json_decode($request->data);
        $avanceMes = AvanceMes::find($id);
        // $avanceMes->update($data);
        Archivo::AgregarArchivos($request, avance_mes_id: $avanceMes->id);
        return response([$avanceMes, $id]);

        // $avanceMes = AvanceMes::find($id)->update($request->all());
        // return response([$avanceMes, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AvanceMes::destroy($id);
        return response($id);
    }
}
