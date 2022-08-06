<?php
/**
 * SymbolController
 *
 * @author: tuanha
 * @date: 28-July-2022
 */
namespace App\Http\Controllers;

use Exception;
use App\FinancialStatement;
use Illuminate\Http\Request;
use App\Jobs\PullFinancialStatement;

class SymbolController extends Controller
{
    /**
     * Display a list of financial statements
     *
     * @return \Illuminate\Http\Response
     */
    public function listFinancialStatements()
    {
        $searchText = request()->input('search');
        try {
            $financial_statements = FinancialStatement::search($searchText)
                    ->simplePaginate(config('bkstar123_bkscms_adminpanel.pageSize'))
                    ->appends([
                        'search' => $searchText
                    ]);
        } catch (Exception $e) {
            $financial_statements = [];
        }
        return view('cms.symbols.statements.index', compact('financial_statements'));
    }

    /**
     * Pull financial statement with the data given in the request
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function pullFinancialStatement(Request $request)
    {
        $request->validate([
            'symbol' => 'required',
            'year' => 'required|integer|between:1900,2100',
            'quarter' => 'required|integer|between:1,4'
        ]);
        $data = $request->except('_token');
        $data['admin_id'] = $request->user()->id;
        try {
            $financialStatement = FinancialStatement::create($data);
            PullFinancialStatement::dispatch($request->except('_token'), $financialStatement->id, $request->user());
            flashing('Your request is being processed')
            ->flash();
        } catch (Exception $e) {
            flashing('Failed to proceed the requested action')
            ->error()
            ->flash();
        }
        return back();
    }

    /**
     * Destroy the selected financial statement
     *
     * @param \App\FinancialStatement $financial_statement
     * @return \Illuminate\Http\Response
     */
    public function destroyFinancialStatement(FinancialStatement $financial_statement)
    {
        try {
            $financial_statement->delete();
            flashing("The selected financial statement has been successfully removed")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Destroy multiple selected financial statements
     *
     * @return \Illuminate\Http\Response
     */
    public function massiveDestroyFinancialStatements()
    {
        $Ids = explode(',', request()->input('Ids'));
        try {
            FinancialStatement::destroy($Ids);
            flashing('All selected financial statements have been removed')
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Display a financial statement
     *
     * @param \App\FinancialStatement $financial_statement
     * @return \Illuminate\Http\Response
     */
    public function showFinancialStatement(FinancialStatement $financial_statement)
    {
        return view('cms.symbols.statements.show', compact('financial_statement'));
    }
}
