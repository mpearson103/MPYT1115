<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Search the database for matching domain entries and return
	 * the entries to the user
	 *
	 * @param Request $request
	 * @return array
	 */
	public function search(Request $request)
	{
		// Process our string into an array
		$domains = explode("\r\n", $request->domains);

		// Query the database
		$response = DB::table('domains')
			->whereIn('domain', $domains)
			->get();

		// Return our response the the view
		return view('domain.list', [
			'response' => $response,
		]);
	}

	/**
     * Create a new domain entry.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'rank' => 'integer|required|min:501',
        ]);

		DB::table('domains')->insert([
			'domain' => $request->domain,
			'rank' => $request->rank,
			'created_at' => 'now()',
		]);

        return redirect('/admin');
    }
}