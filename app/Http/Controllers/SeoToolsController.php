<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeoToolsController extends Controller
{
    public function metaGenerator()
    {
        return view('tools.seo.meta-generator', [
            'title' => 'Meta Tag Generator - SEO Meta Tags',
            'description' => 'Generate SEO-friendly meta tags for your website.'
        ]);
    }

    public function robotsGenerator()
    {
        return view('tools.seo.robots-generator', [
            'title' => 'Robots.txt Generator',
            'description' => 'Create robots.txt file for your website.'
        ]);
    }

    public function serpPreview()
    {
        return view('tools.seo.serp-preview', [
            'title' => 'Google SERP Preview',
            'description' => 'Preview how your page appears in Google search results.'
        ]);
    }

    public function indexChecker()
    {
        return view('tools.seo.index-checker', [
            'title' => 'Google Index Checker',
            'description' => 'Check if your webpage is indexed by Google.'
        ]);
    }

    public function checkIndex(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->input('url');

        try {
            // Fetch the webpage content
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

            $html = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!$html || $httpCode >= 400) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to fetch the URL. HTTP Status: ' . $httpCode
                ], 400);
            }

            // Parse HTML to extract meta tags
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);

            $metaTags = [];
            $metas = $dom->getElementsByTagName('meta');
            foreach ($metas as $meta) {
                $name = $meta->getAttribute('name') ?: $meta->getAttribute('property');
                $content = $meta->getAttribute('content');
                if ($name && $content) {
                    $metaTags[$name] = $content;
                }
            }

            // Get title
            $titleTags = $dom->getElementsByTagName('title');
            $title = $titleTags->length > 0 ? $titleTags->item(0)->textContent : 'No title found';

            // Check if indexed by Google (simplified check via site: search)
            $googleSearchUrl = "https://www.google.com/search?q=site:" . urlencode($url);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $googleSearchUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

            $googleHtml = curl_exec($ch);
            curl_close($ch);

            // Simple check: if Google returns results, it's likely indexed
            $isIndexed = $googleHtml && (strpos($googleHtml, 'did not match any documents') === false);

            return response()->json([
                'success' => true,
                'indexed' => $isIndexed,
                'data' => [
                    'title' => $title,
                    'description' => $metaTags['description'] ?? 'No description found',
                    'keywords' => $metaTags['keywords'] ?? 'No keywords found',
                    'ogTitle' => $metaTags['og:title'] ?? null,
                    'ogDescription' => $metaTags['og:description'] ?? null,
                    'ogImage' => $metaTags['og:image'] ?? null,
                    'twitterCard' => $metaTags['twitter:card'] ?? null,
                    'twitterTitle' => $metaTags['twitter:title'] ?? null,
                    'canonical' => $this->extractCanonical($dom),
                    'robots' => $metaTags['robots'] ?? 'Not specified',
                    'author' => $metaTags['author'] ?? 'Not specified',
                    'allMetaTags' => $metaTags
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function extractCanonical($dom)
    {
        $links = $dom->getElementsByTagName('link');
        foreach ($links as $link) {
            if ($link->getAttribute('rel') === 'canonical') {
                return $link->getAttribute('href');
            }
        }
        return 'Not specified';
    }
}
