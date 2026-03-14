<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class Contact extends Component
{
    public $name;
    public $email;
    public $message;
    public $successMessage;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function sendMessage()
    {
        $this->validate();

        // In a real application, you would use Mail::to() here.
        // For now, we simulate success.
        
        // Send the email to your real inbox addresses
        $recipients = ['buttfaizan875@gmail.com', 'faizanbutt15@yahoo.com'];
        Mail::to($recipients)->send(new ContactFormMail($this->name, $this->email, $this->message));

        $this->reset(['name', 'email', 'message']);
        $this->successMessage = 'Thank you for your message! We will get back to you soon.';
    }

    public function render()
    {
        return view('livewire.contact');
    }
}
