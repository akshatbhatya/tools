@extends('layouts.app')

@section('content')
    <div class="container" style="padding: var(--spacing-xl) 20px; margin-top: 80px;">
        <div class="content-card" style="width: 100%; max-width: 800px; margin: 0 auto;">
            <h1
                style="text-align: center; margin-bottom: var(--spacing-lg); background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Terms of Service</h1>

            <div class="prose" style="color: var(--text-main); line-height: 1.6;">
                <p style="color: var(--text-muted);">Last Updated: {{ date('F d, Y') }}</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">1. Terms</h3>
                <p>By accessing this Website, accessible from {{ url('/') }}, you are agreeing to be bound by these Website
                    Terms and Conditions of Use and agree that you are responsible for the agreement with any applicable
                    local laws. If you disagree with any of these terms, you are prohibited from accessing this site.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">2. Use License</h3>
                <p>Permission is granted to temporarily download one copy of the materials on ToolsHub's Website for
                    personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of
                    title, and under this license you may not:</p>
                <ul style="list-style-type: disc; padding-left: 20px;">
                    <li>modify or copy the materials;</li>
                    <li>use the materials for any commercial purpose or for any public display;</li>
                    <li>attempt to reverse engineer any software contained on ToolsHub's Website;</li>
                    <li>remove any copyright or other proprietary notations from the materials; or</li>
                    <li>transfer the materials to another person or "mirror" the materials on any other server.</li>
                </ul>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">3. Disclaimer</h3>
                <p>All the materials on ToolsHub's Website are provided "as is". ToolsHub makes no warranties, may it be
                    expressed or implied, therefore negates all other warranties. Furthermore, ToolsHub does not make any
                    representations concerning the accuracy or likely results of the use of the materials on its Website or
                    otherwise relating to such materials or on any sites linked to this Website.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">4. Limitations</h3>
                <p>ToolsHub or its suppliers will not be hold accountable for any damages that will arise with the use or
                    inability to use the materials on ToolsHub's Website, even if ToolsHub or an authorize representative of
                    this Website has been notified, orally or written, of the possibility of such damage.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">5. Revisions and Errata</h3>
                <p>The materials appearing on ToolsHub's Website may include technical, typographical, or photographic
                    errors. ToolsHub will not promise that any of the materials in this Website are accurate, complete, or
                    current. ToolsHub may change the materials contained on its Website at any time without notice.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">6. Links</h3>
                <p>ToolsHub has not reviewed all of the sites linked to its Website and is not responsible for the contents
                    of any such linked site. The presence of any link does not imply endorsement by ToolsHub of the site.
                    The use of any linked website is at the user's own risk.</p>
            </div>
        </div>
    </div>
@endsection