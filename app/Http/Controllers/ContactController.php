<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;
use App\Services\SEOService;

class ContactController extends Controller
{
    public function show()
    {
        $locale = session('locale', 'ar');
        $seoMeta = SEOService::getPageMeta('contact', [], $locale);
        return view('contact', compact('seoMeta'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required','string','max:200'],
            'email'   => ['required','email','max:200'],
            'subject' => ['required','string','max:200'],
            'message' => ['required','string','max:5000'],
            'website' => ['nullable','string','max:200'], // honeypot
        ]);

        // honeypot
        if (!empty($data['website'])) {
            return back()->with('success', 'تم استلام رسالتك. شكراً لتواصلك.');
        }

        try {
            $msg = ContactMessage::create([
                'name'    => $data['name'],
                'email'   => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
            ]);

            $body = "اسم المُرسِل: {$data['name']}\n"
                . "البريد: {$data['email']}\n"
                . "الموضوع: {$data['subject']}\n\n"
                . "الرسالة:\n{$data['message']}\n";

            try {
                $defaultMailer = config('mail.default');
                $mailerConfig = $defaultMailer ? config("mail.mailers.$defaultMailer") : null;

                if ($mailerConfig && $defaultMailer !== 'array' && $defaultMailer !== 'log') {
                    Mail::raw($body, function ($m) use ($data) {
                        $m->to('support@wallsmust.org', 'Walls Must Support')
                          ->subject('رسالة جديدة عبر نموذج التواصل: ' . $data['subject']);
                    });
                }
            } catch (\Throwable $mailError) {
                Log::warning('Contact mail error: ' . $mailError->getMessage());
            }

            Log::info('[Contact] رسالة جديدة', [
                'id' => $msg->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
            ]);

            return back()->with('success', 'تم إرسال رسالتك بنجاح. سنعاود التواصل قريباً.');
        } catch (\Throwable $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'تعذّر إرسال الرسالة حالياً. يرجى المحاولة لاحقاً.');
        }
    }
}