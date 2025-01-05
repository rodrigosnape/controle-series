<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;

class SeriesController extends Controller
{
    public function index(Request $request)
    {

        $series = Series::with('seasons')->get();
        //$series = Serie::query()->orderBy('nome')->get();

        $mensagemSucesso = session('mensagem.sucesso');
        //ou
        //$mensagemSucesso = $request->session()->get('mensagem.sucesso');


        return view('series.index',compact('series'))
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $serie = Series::create($request->all());

        for($i = 1; $i <= $request->seasonsQty; $i++){
            $seasons[] = [
                'series_id' => $serie->id,
                'number' => $i,
            ];
        }
        Season::insert($seasons);


        $episodes = [];
        foreach($serie->seasons as $season){
            for($j = 1; $j <= $request->episodesPerSeason; $j++){
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j,
                ];
            }
        }
        Episode::insert($episodes);

        //$request->session()->flash('mensagem.sucesso', "Série '{$serie->nome}' criada com sucesso.");
        return to_route('series.index')
        ->with('mensagem.sucesso', "Série '$serie->nome' criada com sucesso.");

    }

    public function destroy(Series $series)
    {
        $series->delete();
        //->flash funciona. É frescura do inttelephense...
        //$request->session()->flash('mensagem.sucesso', "Série '{{ $series->nome }}' removida com sucesso.");

        return to_route('series.index')->with('mensagem.sucesso', "Série '$series->nome' removida com sucesso.");
    }

    public function edit(Series $series){
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request){

        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '$series->nome' atualizada com sucesso.");
    }
}
