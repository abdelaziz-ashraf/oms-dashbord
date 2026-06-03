<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OMS Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover { background: rgba(255,255,255,0.1); }
        .sidebar-link.active { background: rgba(255,255,255,0.15); border-left: 3px solid white; }
        .section-card { transition: all 0.3s; }
        .section-card:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .active-badge { background: #10b981; color: white; }
        .inactive-badge { background: #ef4444; color: white; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1f2937; }
        ::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
    </style>
</head>
<body class="bg-slate-100">
    <div class="min-h-screen flex">
        <aside class="w-72 bg-gradient-to-b from-slate-900 to-slate-800 text-white flex flex-col fixed h-full">
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cube text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">OMS</h1>
                        <p class="text-xs text-slate-400">Landing Page Editor</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 p-4 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie w-5"></i>
                    <span>Overview</span>
                </a>

                <a href="{{ route('admin.contact-messages.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg mb-2 {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                    <i class="fas fa-inbox w-5 text-blue-400"></i>
                    <span>Contact Inbox</span>
                </a>
                
                <div class="mt-6">
                    <p class="px-4 text-xs text-slate-500 uppercase tracking-wider mb-3 font-semibold">Page Sections</p>
                    <a href="{{ route('admin.section', 'announcement') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/announcement') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn w-5 text-amber-400"></i>
                        <span>Announcement</span>
                    </a>
                    <a href="{{ route('admin.section', 'hero') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/hero') ? 'active' : '' }}">
                        <i class="fas fa-image w-5 text-cyan-400"></i>
                        <span>Hero</span>
                    </a>
                    <a href="{{ route('admin.section', 'problem') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/problem') ? 'active' : '' }}">
                        <i class="fas fa-exclamation-circle w-5 text-red-400"></i>
                        <span>Problem</span>
                    </a>
                    <a href="{{ route('admin.section', 'features') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/features') ? 'active' : '' }}">
                        <i class="fas fa-star w-5 text-yellow-400"></i>
                        <span>Features</span>
                    </a>
                    <a href="{{ route('admin.section', 'packages') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/packages') ? 'active' : '' }}">
                        <i class="fas fa-box w-5 text-green-400"></i>
                        <span>Packages</span>
                    </a>
                    <a href="{{ route('admin.section', 'audience') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/audience') ? 'active' : '' }}">
                        <i class="fas fa-users w-5 text-blue-400"></i>
                        <span>Target Audience</span>
                    </a>
                    <a href="{{ route('admin.section', 'social-proof') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/social-proof') ? 'active' : '' }}">
                        <i class="fas fa-award w-5 text-purple-400"></i>
                        <span>Social Proof</span>
                    </a>
                    <a href="{{ route('admin.section', 'why-us') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/why-us') ? 'active' : '' }}">
                        <i class="fas fa-check-circle w-5 text-emerald-400"></i>
                        <span>Why Us</span>
                    </a>
                    <a href="{{ route('admin.section', 'how-it-works') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/how-it-works') ? 'active' : '' }}">
                        <i class="fas fa-cogs w-5 text-orange-400"></i>
                        <span>How It Works</span>
                    </a>
                    <a href="{{ route('admin.section', 'comparison') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/comparison') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale w-5 text-teal-400"></i>
                        <span>Comparison</span>
                    </a>
                    <a href="{{ route('admin.section', 'faq') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/faq') ? 'active' : '' }}">
                        <i class="fas fa-question-circle w-5 text-pink-400"></i>
                        <span>FAQ</span>
                    </a>
                    <a href="{{ route('admin.section', 'cta') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/cta') ? 'active' : '' }}">
                        <i class="fas fa-hand-pointer w-5 text-indigo-400"></i>
                        <span>CTA</span>
                    </a>
                    <a href="{{ route('admin.section', 'contact') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/contact') ? 'active' : '' }}">
                        <i class="fas fa-envelope w-5 text-cyan-400"></i>
                        <span>Contact</span>
                    </a>
                    <a href="{{ route('admin.section', 'footer') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/section/footer') ? 'active' : '' }}">
                        <i class="fas fa-grip-lines w-5 text-slate-400"></i>
                        <span>Footer</span>
                    </a>
                </div>

                <div class="mt-6">
                    <p class="px-4 text-xs text-slate-500 uppercase tracking-wider mb-3 font-semibold">Portfolio</p>
                    @php
                        $portfolioLinks = [
                            ['key' => 'services', 'icon' => 'briefcase', 'label' => 'Services'],
                            ['key' => 'projects', 'icon' => 'folder-open', 'label' => 'Projects'],
                            ['key' => 'case-studies', 'icon' => 'file-alt', 'label' => 'Case Studies'],
                            ['key' => 'team', 'icon' => 'user-friends', 'label' => 'Team'],
                            ['key' => 'testimonials', 'icon' => 'quote-left', 'label' => 'Testimonials'],
                            ['key' => 'clients', 'icon' => 'building', 'label' => 'Clients'],
                            ['key' => 'blog', 'icon' => 'newspaper', 'label' => 'Blog'],
                        ];
                    @endphp
                    @foreach($portfolioLinks as $link)
                        <a href="{{ route('admin.portfolio.index', $link['key']) }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg mb-1 {{ request()->is('admin/portfolio/'.$link['key']) ? 'active' : '' }}">
                            <i class="fas fa-{{ $link['icon'] }} w-5 text-slate-400"></i>
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </nav>
            
            <div class="p-4 border-t border-slate-700 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm font-medium transition" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    View Live Site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-72 p-8">
            <div class="max-w-5xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const container = this.previousElementSibling;
                    const items = container.querySelectorAll('.item-item');
                    const index = items.length;
                    const template = container.querySelector('.item-template');
                    if (template) {
                        const clone = template.content.cloneNode(true);
                        const html = clone.querySelector('.item-item').outerHTML;
                        const newHtml = html.replace(/__INDEX__/g, index);
                        container.insertAdjacentHTML('beforeend', newHtml);
                    }
                });
            });

            document.querySelectorAll('.add-social-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const container = document.getElementById(this.dataset.target);
                    const template = container?.querySelector('.item-template');

                    if (!container || !template) {
                        return;
                    }

                    const index = Array.from(container.children).filter(child => child.classList.contains('item-item')).length;
                    const clone = template.content.cloneNode(true);
                    const html = clone.querySelector('.item-item').outerHTML;
                    const newHtml = html.replace(/__INDEX__/g, index);
                    container.insertAdjacentHTML('beforeend', newHtml);
                });
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item-btn') || e.target.closest('.remove-item-btn')) {
                    const target = e.target.classList.contains('remove-item-btn') ? e.target : e.target.closest('.remove-item-btn');
                    target.closest('.item-item').remove();
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
