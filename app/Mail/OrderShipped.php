<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_details)
    {
        $this->order_details = $order_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // getting the security code using explicit helper function
        $security_code = getSecurityCode();
        // store the security code in session for validation
        session(['security_code'=>$security_code]);
        // return $this->order_details;
        // order id for the checkout product we need it to modify the view for email
        $order = Order::find($this->order_details->order);
        // view for the shipped email
        return $this->from('noreply@juju.com')
                ->subject('Confirmation For Purchase Of Order')
                ->view('emails.orders.shipped')
                ->with([
                    'security_code'=>$security_code,
                    'order' => $order,
                    'name' => $this->order_details->name,
                    'number'=>$this->order_details->number,
                    'country_name'=>$this->order_details->country_name,
                    'state'=>$this->order_details->state,
                    'post'=>$this->order_details->post,
                    'address1'=>$this->order_details->address1,
                    'address2'=>$this->order_details->address2
                    ]);
    }
}
