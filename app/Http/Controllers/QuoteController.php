<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Quote;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $quotes = Quote::when($search, function($query) use ($search){
            $query->where('company_name', 'LIKE', "%$search%")
                  ->orWhere('client_name', 'LIKE', "%$search%")
                  ->orWhere('quote_number', 'LIKE', "%$search%");
        })->get();

         // If AJAX request → return JSON only
         if ($request->ajax()&& $request->has('search')) {
           return response()->json(['quotes' => $quotes]);
         }

        return view('quotes', compact('quotes'));
    }


/*     public function client(Request $request)
    {
        $search = $request->search;

        $quotes = Quote::when($search, function($query) use ($search){
            $query->where('company_name', 'LIKE', "%$search%")
                  ->orWhere('client_name', 'LIKE', "%$search%")
                  ->orWhere('quote_number', 'LIKE', "%$search%");
        })->get();

         // If AJAX request → return JSON only
         if ($request->ajax()&& $request->has('search')) {
           return response()->json(['quotes' => $quotes]);
         }

        return view('client_quotes', compact('quotes'));
    }
 */    


    public function generateQuoteNumber($quote){
        $qid = $quote->id;
        $quote_uuid = Str::uuid();

        $update = $quote->update([
             'quote_number'=> "q".str_pad($qid, 4, '0', STR_PAD_LEFT).$quote_uuid
        ]);
        if(!$update){
           return false;  
        }
        return true;
    }

    public function client(Request $request)
    {
      $search = $request->search;
      $userId = auth()->id(); // current logged-in client

      $quotes = Quote::where('client_id', $userId)   // restrict to current client only
        ->when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'LIKE', "%$search%")
                  ->orWhere('client_name', 'LIKE', "%$search%")
                  ->orWhere('quote_number', 'LIKE', "%$search%");
            });
        })
        ->get();

      // If AJAX request → return JSON only
      if ($request->ajax() && $request->has('search')) {
        return response()->json(['quotes' => $quotes]);
      }

      return view('client_quotes', compact('quotes'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required',
            'client_name' => 'required',
            'items' => 'required|array|min:1'
        ]);

       /*$items = collect($request->items)->values()->all();

        $subTotal = collect($items)->sum(fn($i) => $i['quantity'] * $i['price']); */

        $items = collect($request->items)->map(function ($i) {
             return [
              'item'  => $i['name'],
              'qty'   => $i['quantity'],   // convert to qty
              'price' => $i['price'],
              'total' => $i['quantity'] * $i['price']
             ];
        })->values()->all();

        $subTotal = collect($items)->sum('total'); 
         


        $quote = Quote::create([
            'company_name'      => $request->company_name,
            'company_address'   => $request->company_address,
            'company_email'     => $request->company_email,
            'company_contact'   => $request->company_contact,
            'company_date'      => $request->company_date,
            'company_website'   => $request->company_website,

            'client_name'       => $request->client_name,
            'client_address'    => $request->client_address,
            'client_email'      => $request->client_email,
            'client_contact'    => $request->client_contact,
            'quote_valid_date'  => $request->quote_valid_date,

            'project_title'     => $request->title,

            'items'             => json_encode($items),

            'sub_total'         => $subTotal,
            'tax'               => $request->tax ?? 0,
            'discount'          => $request->discount ?? 0,
            'grand_total'       => ($subTotal + ($request->tax ?? 0)) - ($request->discount ?? 0)
        ]);

        $this->generateQuoteNumber($quote);

        
        $quote_id = $quote->id;
        foreach($items as $item){
           $task = Task::create([
             "title" => $item['item'],
             "project_id" =>  $quote_id
           ]);
        };

        return response()->json([
              "success" => true,
              "message" => "Quote created successfuly!."
        ]);
    }

    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);
        $q_status = $quote->status;

        /*$items = collect($request->items)->values()->all();
        $subTotal = collect($items)->sum(fn($i) => $i['quantity'] * $i['price']); */

        $items = collect($request->items)->map(function ($i) {
            return [
             'item'  => $i['name'],
             'qty'   => $i['qty'],
             'price' => $i['price'],
             'total' => $i['qty'] * $i['price']
            ];
        })->values()->all();

        $subTotal = collect($items)->sum('total');
       

       // }        

         $quote->update([
            'company_name'      => $request->company_name,
            'company_address'   => $request->company_address,
            'company_email'     => $request->company_email,
            'company_contact'   => $request->company_contact,
            'company_date'      => $request->company_date,
            'company_website'   => $request->company_website,

            'client_name'       => $request->client_name,
            'client_address'    => $request->client_address,
            'client_email'      => $request->client_email,
            'client_contact'    => $request->client_contact,
            'quote_valid_date'  => $request->quote_valid_date,

            'items'             => json_encode($items),
            'project_title'     => $request->title,

            'sub_total'         => $subTotal,
            'tax'               => $request->tax ?? 0,
            'discount'          => $request->discount ?? 0,
            'grand_total'       => ($subTotal + ($request->tax ?? 0)) - ($request->discount ?? 0)
        ]);
        

        if(!($q_status === "accepted") && ($request->status === "accepted")){
           // if($request->status === "accepted"){
                $project = Project::create([
                        "quote_id" => $quote->id,
                        "title"    => $quote->project_title,
                        "status"   => "in_progress"
                    ]);   
                if($project){
                    return response()->json([
                        "success" => true,
                        "message" => "Quote updated successfully and It's project created!.".$q_status." and ".$quote->status
                    ]);
                }
        }  

        return response()->json([
            "success" => true,
            "message" => "Quote updated successfuly!."
        ]);

    }

    public function destroy($id)
    {
        Quote::findOrFail($id)->delete();
        return response()->json([
              "success" => true,
              "message" => "Quote deleted successfuly!."
        ]);
    }

    public function downloadPdf($id)
    {
        $quote = Quote::findOrFail($id);

        $quote->items = json_decode($quote->items, true);

        $pdf = Pdf::loadView('pdf.quote-pdf', compact('quote'));

        return $pdf->download("Quote-{$quote->id}.pdf");
    }

    public function viewPdf($id)
    {
         $quote = Quote::findOrFail($id);

         $quote->items = json_decode($quote->items, true);

         // return $pdf->stream('quote.pdf');
         return view('pdf.quote-pdf', compact('quote'));
    }



    // PDF Export
    public function exportPDF(Request $request)
    {
    $query = Quote::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('company_name', 'LIKE', "%$search%")
              ->orWhere('client_name', 'LIKE', "%$search%")
              ->orWhere('quote_number', 'LIKE', "%$search%");
        });
    }

    $quotes = $query->orderBy('id', 'desc')->get();

    $printedBy = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    $date = now()->format('Y-m-d H:i:s');

    $pdf = PDF::loadView('/pdf/quotes-pdf', compact('quotes', 'printedBy', 'date'));

    return $pdf->download('quotes_' . now()->format('Ymd_His') . '.pdf');
   }

}
