<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\ShortLink;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle   = 'Home';
        $sections    = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::home', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function pages($slug)
    {
        $page        = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle   = $page->name;
        $sections    = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function contact()
    {
        $pageTitle   = "Contact Us";
        $user        = auth()->user();
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::contact', compact('pageTitle', 'user', 'sections', 'seoContents', 'seoImage'));
    }

    public function redirectShortLink($code)
    {
        $shortLink = ShortLink::where('code', $code)->firstOrFail();
        $shortLink->increment('click');

        $url = "https://api.whatsapp.com/send?phone=" . $shortLink->dial_code . $shortLink->mobile . "&text=" . urlencode($shortLink->message);
        return redirect($url);
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required',
            'subject'   => 'required|string|max:255',
            'message'   => 'required',
        ]);

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->firstname . " " . $request->lastname;
        $ticket->email    = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;

        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
            ]);
        };

        $subsriber        = new Subscriber();
        $subsriber->email = $request->email;
        $subsriber->save();

        return response()->json([
            'success' => true,
            'message' => "You have successfully subscribed!",
        ]);
    }

    public function policyPages($slug)
    {
        $policy      = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle   = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) {
            $lang = 'en';
        }
        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $pageTitle   = gs('site_name') . ' Blogs';
        $blogs       = Frontend::where('data_keys', 'blog.element')->paginate(getPaginate(21));
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'blog')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;

        return view('Template::blogs', compact('pageTitle', 'blogs', 'sections', 'seoContents', 'seoImage'));
    }

    public function blogDetails($slug)
    {
        $blog        = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $allBlogs    = Frontend::whereNot('id', $blog->id)->where('data_keys', 'blog.element')->latest('id')->paginate(getPaginate());
        $pageTitle   = $blog->data_values->title;
        $seoContents = $blog->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::blog_details', compact('blog', 'pageTitle', 'seoContents', 'seoImage', 'allBlogs'));
    }

    public function features()
    {
        $pageTitle = gs('site_name') . ' Features';
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'feature')->first();
        return view('Template::features', compact('pageTitle', 'sections'));
    }

    public function pricing()
    {
        $pageTitle = gs('site_name') . ' Pricing';
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'pricing')->first();
        return view('Template::pricing', compact('pageTitle', 'sections'));
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        try {
            // Validar parâmetro size
            if (!$size || !str_contains($size, 'x')) {
                return $this->placeholderImageSvg('400x400');
            }

            // Verificar se GD está disponível
            if (!function_exists('imagecreatetruecolor')) {
                return $this->placeholderImageSvg($size);
            }

            $dimensions = explode('x', $size);
            $imgWidth  = (int) ($dimensions[0] ?? 400);
            $imgHeight = (int) ($dimensions[1] ?? 400);
            
            // Validar dimensões
            if ($imgWidth < 1 || $imgHeight < 1 || $imgWidth > 2000 || $imgHeight > 2000) {
                return $this->placeholderImageSvg('400x400');
            }
            
            $text      = $imgWidth . '×' . $imgHeight;
            $fontFile  = realpath('assets/font/solaimanLipi_bold.ttf');
            
            // Verificar se a fonte existe
            if (!$fontFile || !file_exists($fontFile)) {
                return $this->placeholderImageSvg($size);
            }
            
            $fontSize  = round(($imgWidth - 50) / 8);
            if ($fontSize <= 9) {
                $fontSize = 9;
            }
            if ($imgHeight < 100 && $fontSize > 30) {
                $fontSize = 30;
            }

            $image     = imagecreatetruecolor($imgWidth, $imgHeight);
            $colorFill = imagecolorallocate($image, 100, 100, 100);
            $bgFill    = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $bgFill);
            $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
            $textWidth  = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $textX      = ($imgWidth - $textWidth) / 2;
            $textY      = ($imgHeight + $textHeight) / 2;
            
            // Capturar output da imagem em buffer
            ob_start();
            imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
            imagejpeg($image, null, 90);
            $imageData = ob_get_clean();
            imagedestroy($image);
            
            // Retornar resposta Laravel adequada
            return response($imageData)
                ->header('Content-Type', 'image/jpeg')
                ->header('Cache-Control', 'public, max-age=31536000');
                
        } catch (\Exception $e) {
            // Em caso de erro, retornar SVG
            return $this->placeholderImageSvg($size ?? '400x400');
        }
    }

    private function placeholderImageSvg($size = null)
    {
        // Validar e parsear tamanho
        if (!$size || !str_contains($size, 'x')) {
            $size = '400x400';
        }
        
        $dimensions = explode('x', $size);
        $width = (int) ($dimensions[0] ?? 400);
        $height = (int) ($dimensions[1] ?? 400);
        
        // Validar dimensões
        if ($width < 1 || $height < 1) {
            $width = 400;
            $height = 400;
        }
        if ($width > 2000) $width = 2000;
        if ($height > 2000) $height = 2000;
        
        $text = $width . '×' . $height;
        $fontSize = min(24, max(12, $width / 20));
        
        $svg = <<<SVG
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
    <rect width="{$width}" height="{$height}" fill="#f0f0f0"/>
    <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="{$fontSize}" fill="#666" 
          text-anchor="middle" dominant-baseline="middle">{$text}</text>
</svg>
SVG;
        
        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=31536000');
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }
}

