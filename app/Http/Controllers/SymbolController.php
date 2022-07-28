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
}
