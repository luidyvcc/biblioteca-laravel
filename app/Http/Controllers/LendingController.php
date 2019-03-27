<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LendingController extends Controller
{
    private $lending;
    private $totalPage;

    public function __construct(Lending $lending)
    {
        $this->lending = $lending;
        $this->totalPage = 4;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Lista de emprestimos';

        $lendings = $this->lending->with(['user','books'])->paginate($this->totalPage);

        return view('lendings.index', compact('title','lendings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $insert = false;

        if (session()->has('cart')){
            $user_id = auth()->user()->id;
            $date_start = Carbon::now();
            $date_end = Carbon::now()->addDays(7);
            $this->lending->user_id = $user_id;
            $this->lending->date_start = $date_start;
            $this->lending->date_end = $date_end;
            $insert = $this->lending->save();
            $this->lending->books()->attach(session('cart'));
            session()->forget('cart');
        }

        return $insert ?
            redirect()
                ->route('lendings.index')
                ->with('success', 'Emprestimo realizado com sucesso!') :
            redirect()
                ->back()
                ->with('error', 'Erro ao concluir emprestimo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function finish($id)
    {
        $lending = $this->lending->find($id);

        if (!$lending) return redirect()->back()->with('error', 'Falha ao entregar!');

        $update = $lending->update(['date_finish' => Carbon::now()]);

        return $update ?
            redirect()
                ->route('lendings.index')
                ->with('success', 'Entregue com sucesso!') :
            redirect()
                ->back()
                ->with('error', 'Falha ao entregar!');
    }
}
