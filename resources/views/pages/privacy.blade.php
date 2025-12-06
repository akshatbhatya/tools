@extends('layouts.app')

@section('content')
    <div class="container" style="padding: var(--spacing-xl) 20px; margin-top: 80px;">
        <div class="content-card" style="width: 100%; max-width: 800px; margin: 0 auto;">
            <h1
                style="text-align: center; margin-bottom: var(--spacing-lg); background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Privacy Policy</h1>

            <div class="prose" style="color: var(--text-main); line-height: 1.6;">
                <p style="color: var(--text-muted);">Last Updated: {{ date('F d, Y') }}</p>

                <p>At ToolsHub, accessible from {{ url('/') }}, one of our main priorities is the privacy of our visitors.
                    This Privacy Policy document contains types of information that is collected and recorded by ToolsHub
                    and how we use it.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Log Files</h3>
                <p>ToolsHub follows a standard procedure of using log files. These files log visitors when they visit
                    websites. All hosting companies do this and a part of hosting services' analytics. The information
                    collected by log files includes internet protocol (IP) addresses, browser type, Internet Service
                    Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are
                    not linked to any information that is personally identifiable.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Cookies and Web Beacons</h3>
                <p>Like any other website, ToolsHub uses 'cookies'. These cookies are used to store information including
                    visitors' preferences, and the pages on the website that the visitor accessed or visited. The
                    information is used to optimize the users' experience by customizing our web page content based on
                    visitors' browser type and/or other information.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Google DoubleClick DART Cookie</h3>
                <p>Google is one of a third-party vendor on our site. It also uses cookies, known as DART cookies, to serve
                    ads to our site visitors based upon their visit to www.website.com and other sites on the internet.
                    However, visitors may choose to decline the use of DART cookies by visiting the Google ad and content
                    network Privacy Policy at the following URL – <a href="https://policies.google.com/technologies/ads"
                        target="_blank" style="color: var(--neon-accent);">https://policies.google.com/technologies/ads</a>
                </p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Data Security</h3>
                <p>We take data security seriously. Files uploaded to our tools (such as PDF or Image tools) are processed
                    securely and are automatically deleted from our servers after a short period (usually within 1 hour). We
                    do not permanently store your uploaded files or share them with third parties.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Consent</h3>
                <p>By using our website, you hereby consent to our Privacy Policy and agree to its Terms and Conditions.</p>
            </div>
        </div>
    </div>
@endsection