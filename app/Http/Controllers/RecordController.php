<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Throwable;

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;


class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function importRecords(Request $request)
    {
        $this->validate($request, [
            'csv' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        try {
            // dd($request->file('csv'));

            $config = new LexerConfig();

            $config->setIgnoreHeaderLine(true);

            $lexer = new Lexer($config);
            $interpreter = new Interpreter();

            $interpreter->addObserver(function(array $columns) {
            //    dd($columns);
            // var_dump($columns);

                Record::create([
                    'name'          => $columns[0],
                    'batch_number'  => $columns[1],
                    'sellingprice'  => $columns[2],
                    'buyingprice'   => $columns[3]
                ]);
            });
            
            $lexer->parse($request->file('csv'), $interpreter);
            return response()->json(['message' => 'Records imported successfully.'], 200);
        } 
        catch (Throwable $r) {
            return redirect()->back()->with('error', $r->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
    }
}
