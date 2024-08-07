<?php

namespace App\View\Components;

use App\Models\GatewayCurrency;
use App\Constants\Status;
use Illuminate\View\Component;

class PurchaseModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $wallet;

    public function __construct($wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        return view('components.purchase-modal', [
            'gatewayCurrency' => $gatewayCurrency,
            'wallet' => $this->wallet,
        ]);
    }
}
