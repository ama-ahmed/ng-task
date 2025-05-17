<?php

namespace Modules\Log\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Log\Services\LogService;

class LogController extends Controller
{
    public function __construct(public LogService $service)
    {
        
    }
    public function index()
    {
        $items = $this->service->paginate();
        return view('log::admin.index', ['items' => $items]);
    }
}
